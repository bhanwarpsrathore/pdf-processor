<?php

namespace Bhanwarpsrathore\PdfProcessor\Laravel\Concerns;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Str;

class Disk {
    private ?string $disk;
    private string  $temporaryDirectory;


    public function __construct(?string $disk = null) {
        $this->disk = $disk;
        $this->temporaryDirectory = pdf_temp_dir() . '/pdf-processor/' . Str::uuid()->toString();
    }

    public function __destruct() {
        $this->cleanupTemporaryDirectory();
    }

    public static function make(?string $disk = null): self {
        return new static($disk);
    }


    public function getAdapter(): ?FilesystemAdapter {
        return $this->disk ? app('filesystem')->disk($this->disk) : null;
    }

    public function getTemporaryDisk(): FilesystemAdapter {
        if (!is_dir($this->temporaryDirectory)) {
            mkdir($this->temporaryDirectory, 0777, true);
        }

        return app('filesystem')->createLocalDriver([
            'root' => $this->temporaryDirectory,
        ]);
    }

    public function cleanupTemporaryDirectory(): self {
        $filesystem = new Filesystem();
        $filesystem->deleteDirectory($this->temporaryDirectory);

        return $this;
    }

    public function isLocalDisk(): bool {
        if ($this->getAdapter()) {
            return config("filesystems.disks.$this->disk.driver") == 'local';
        }

        return false;
    }
}
