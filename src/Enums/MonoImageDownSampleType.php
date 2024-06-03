<?php

namespace Bhanwarpsrathore\PdfProcessor\Enums;

enum MonoImageDownSampleType: string {
    case SUB_SAMPLE = '/Subsample';
    case AVERAGE    = '/Average';
    case BICUBIC    = '/Bicubic';
}
