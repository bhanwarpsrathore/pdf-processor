<?php

namespace Bhanwarpsrathore\PdfProcessor\Laravel\Concerns;

use Bhanwarpsrathore\PdfProcessor\Actions\ProcessPdfAction;
use Bhanwarpsrathore\PdfProcessor\Concerns\ExportsScript;
use Bhanwarpsrathore\PdfProcessor\Concerns\PdfProcessorProperties;
use Bhanwarpsrathore\PdfProcessor\DTOs\ProcessResult;
use Bhanwarpsrathore\PdfProcessor\DTOs\PdfProcessorJobData;
use Bhanwarpsrathore\PdfProcessor\DTOs\QueueData;
use Bhanwarpsrathore\PdfProcessor\Jobs\PdfProcessorJob;
use Psr\Log\LoggerInterface;

class Export {
    use PdfProcessorProperties, ExportsScript;

    private readonly File    $file;
    private string           $gsBinary;
    private ?string          $disk   = null;
    private ?LoggerInterface $logger = null;
    private QueueData        $queue;


    public function __construct(File $file, string $gsBinary = 'gs') {
        $this->file = $file;
        $this->gsBinary = $gsBinary;
        $this->timeout = config('pdf-processor.timeout');

        $queue = config('pdf-processor.queue');

        $this->queue = QueueData::make(
            $queue['enabled'],
            $queue['name'],
            $queue['connection'],
            $queue['timeout']
        );
    }

    public function toDisk(string $disk): self {
        $this->disk = $disk;

        return $this;
    }

    public function setGsBinary(string $binary): self {
        $this->gsBinary = $binary;

        return $this;
    }

    public function onQueue(bool $enabled = true, string $name = 'default', ?string $connection = null, int $timeout = 900): self {
        $this->queue = QueueData::make($enabled, $name, $connection, $timeout);

        return $this;
    }

    public function logger(LoggerInterface $logger): self {
        $this->logger = $logger;

        return $this;
    }

    public function process(string $pathToProcessedFile): ProcessResult {
        $disk = Disk::make($this->disk);

        $commands = $this->command();
        $input = $this->file->getPath();

        if ($this->queue->enabled) {
            return $this->processOnQueue(
                $commands,
                $input,
                $pathToProcessedFile,
                $disk
            );
        }

        return ProcessPdfAction::init($this->file, $disk)
            ->logger($this->logger)
            ->setTimeout($this->timeout)
            ->execute(
                $commands,
                $input,
                $pathToProcessedFile
            );
    }

    private function processOnQueue(array $commands, string $input, string $output, Disk $disk): ProcessResult {
        $data = PdfProcessorJobData::make(
            commands: $commands,
            input: $input,
            output: $output,
            file: $this->file,
            disk: $disk,
            logger: $this->logger,
            timeout: $this->queue->timeout
        );

        PdfProcessorJob::dispatch($data)
            ->onQueue($this->queue->name)
            ->onConnection($this->queue->connection);

        return ProcessResult::make(true, true, $data->id);
    }
}
