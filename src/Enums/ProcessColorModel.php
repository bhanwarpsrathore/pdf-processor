<?php

namespace Bhanwarpsrathore\PdfProcessor\Enums;

enum ProcessColorModel: string {
    case GRAY = 'DeviceGray';
    case RGB  = 'DeviceRGB';
    case CMYK = 'DeviceCMYK';
}
