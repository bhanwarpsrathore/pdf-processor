<?php

namespace Bhanwarpsrathore\PdfProcessor\Enums;

enum GrayImageDownSampleType: string {
    case SUB_SAMPLE = '/Subsample';
    case AVERAGE    = '/Average';
    case BICUBIC    = '/Bicubic';
}
