<?php

namespace Bhanwarpsrathore\PdfProcessor\Enums;

enum ImageFilter: string {
    case JPEG = '/DCTEncode';
    case ZIP  = '/FlateEncode';
}
