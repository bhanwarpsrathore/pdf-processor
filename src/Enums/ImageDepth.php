<?php

namespace Bhanwarpsrathore\PdfProcessor\Enums;

enum ImageDepth: int {
    case ONE       = 1;
    case TWO       = 2;
    case FOUR      = 4;
    case EIGHT     = 8;
    case UNCHANGED = -1;
}
