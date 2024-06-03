<?php

namespace Bhanwarpsrathore\PdfProcessor\Enums;

enum AutoRotatePages: string {
    case NONE         = '/None';
    case ALL          = '/All';
    case PAGE_BY_PAGE = '/PageByPage';
}
