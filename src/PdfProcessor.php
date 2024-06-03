<?php

namespace Bhanwarpsrathore\PdfProcessor;

use Bhanwarpsrathore\PdfProcessor\Actions\ProcessPdfAction;
use Bhanwarpsrathore\PdfProcessor\Concerns\ExportsScript;
use Bhanwarpsrathore\PdfProcessor\Concerns\PdfProcessorProperties;
use Bhanwarpsrathore\PdfProcessor\DTOs\ProcessResult;
use Psr\Log\LoggerInterface;

class PdfProcessor {
    use PdfProcessorProperties, ExportsScript;

    private ?LoggerInterface $logger = null;

    public function __construct(
        private readonly string $gsBinary = 'gs',
    ) {
    }

    public static function init(string $gsBinary = 'gs'): self {
        return new self($gsBinary);
    }

    public function logger(LoggerInterface $logger): self {
        $this->logger = $logger;

        return $this;
    }

    public function optimize(string $pathToFile, string $pathToOptimizedFile): ProcessResult {
        return ProcessPdfAction::init()
            ->logger($this->logger)
            ->setTimeout($this->timeout)
            ->execute(
                command: $this->command(),
                input: $pathToFile,
                output: $pathToOptimizedFile
            );
    }
}
