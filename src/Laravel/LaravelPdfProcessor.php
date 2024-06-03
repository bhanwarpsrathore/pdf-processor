<?php

namespace Bhanwarpsrathore\PdfProcessor\Laravel;

use Illuminate\Http\UploadedFile;
use Bhanwarpsrathore\PdfProcessor\Laravel\Concerns\Export;
use Bhanwarpsrathore\PdfProcessor\Laravel\Concerns\File;

class LaravelPdfProcessor {
    private ?string $disk = null;

    public function fromDisk(string $disk): self {
        $this->disk = $disk;

        return $this;
    }

    public function open(UploadedFile|string $file): Export {
        if ($file instanceof UploadedFile) {
            $this->disk = null;

            $file = File::make($file->getRealPath(), $this->disk);
        } else {
            $file = File::make($file, $this->disk);
        }

        return new Export($file, config('pdf-processor.gs'));
    }
}
