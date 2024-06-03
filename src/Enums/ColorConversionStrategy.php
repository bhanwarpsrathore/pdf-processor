<?php

namespace Bhanwarpsrathore\PdfProcessor\Enums;

enum ColorConversionStrategy: string {
    case UNCHANGED                = 'LeaveColorUnchanged';
    case GRAY                     = 'Gray';
    case RGB                      = 'RGB';
    case CMYK                     = 'CMYK';
    case DEVICE_INDEPENDENT_COLOR = 'UseDeviceIndependentColor';
}
