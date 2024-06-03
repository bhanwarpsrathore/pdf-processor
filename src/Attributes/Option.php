<?php

namespace Bhanwarpsrathore\PdfProcessor\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Option {
    public function __construct(public string $name) {
    }
}
