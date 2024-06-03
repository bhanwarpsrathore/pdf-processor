<?php

namespace Bhanwarpsrathore\PdfProcessor\DTOs;

readonly class ProcessResult {
    public function __construct(
        public bool    $status,
        public bool    $isQueued = false,
        public ?string $queueId = null,
        public string  $message = ''
    ) {
    }


    public static function make(bool $status, bool $isQueued = false, ?string $queueId = null, string $message = ''): self {
        return new self($status, $isQueued, $queueId, $message);
    }
}
