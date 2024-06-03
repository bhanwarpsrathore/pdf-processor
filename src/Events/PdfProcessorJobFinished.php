<?php

namespace Bhanwarpsrathore\PdfProcessor\Events;

use Illuminate\Queue\SerializesModels;

class PdfProcessorJobFinished {
    use SerializesModels;

    public function __construct(
        public readonly string $id,
        public readonly bool   $status,
        public readonly string $message
    ) {
    }
}
