<?php

namespace Bhanwarpsrathore\PdfProcessor\Laravel\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Bhanwarpsrathore\PdfProcessor\Laravel\LaravelPdfProcessor fromDisk(string $disk)
 * @method static \Bhanwarpsrathore\PdfProcessor\Laravel\Concerns\Export open(\Illuminate\Http\UploadedFile|string $file)
 *
 * @see \Bhanwarpsrathore\PdfProcessor\Laravel\LaravelPdfProcessor
 */
class PdfProcessor extends Facade {
    protected static function getFacadeAccessor(): string {
        return 'Bhanwarpsrathore\PdfProcessor\Laravel\LaravelPdfProcessor';
    }
}
