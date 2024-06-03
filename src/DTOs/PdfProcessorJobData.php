<?php

namespace Bhanwarpsrathore\PdfProcessor\DTOs;

use Illuminate\Support\Str;
use Bhanwarpsrathore\PdfProcessor\Laravel\Concerns\Disk;
use Bhanwarpsrathore\PdfProcessor\Laravel\Concerns\File;
use Psr\Log\LoggerInterface;

readonly class PdfProcessorJobData {
    public function __construct(
        public string           $id,
        public array            $commands,
        public string           $input,
        public string           $output,
        public ?File            $file = null,
        public ?Disk            $disk = null,
        public ?LoggerInterface $logger = null,
        public int              $timeout = 900
    ) {
    }

    public static function make(array $commands, string $input, string $output, File $file, ?Disk $disk = null, ?LoggerInterface $logger = null, int $timeout = 900): self {
        $id = Str::orderedUuid()->toString();

        return new self($id, $commands, $input, $output, $file, $disk, $logger, $timeout);
    }
}
