<?php

namespace Bhanwarpsrathore\PdfProcessor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Bhanwarpsrathore\PdfProcessor\Actions\ProcessPdfAction;
use Bhanwarpsrathore\PdfProcessor\DTOs\PdfProcessorJobData;
use Bhanwarpsrathore\PdfProcessor\Events\PdfProcessorJobFinished;

class PdfProcessorJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly PdfProcessorJobData $data) {
    }

    public function handle(): void {
        $this->data->logger?->info("Job {$this->data->id} started.");

        $result = ProcessPdfAction::init($this->data->file, $this->data->disk)
            ->logger($this->data->logger)
            ->setTimeout($this->data->timeout)
            ->execute(
                $this->data->commands,
                $this->data->input,
                $this->data->output
            );

        event(
            new PdfProcessorJobFinished($this->data->id, $result->status, $result->message)
        );

        if ($result->status) {
            $this->data->logger?->info('Job finished successfully.');
        } else {
            $this->data->logger?->error('Job finished with error.');

            $this->fail($result->message);
        }
    }
}
