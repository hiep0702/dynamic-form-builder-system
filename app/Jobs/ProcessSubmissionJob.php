<?php

namespace App\Jobs;

use App\Domain\Submission\Entities\Submission;
use App\Domain\Submission\Repositories\SubmissionRepositoryInterface;
use App\Domain\Submission\ValueObjects\SubmissionStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Submission $submission
    ) {
    }

    public function handle(SubmissionRepositoryInterface $submissionRepository): void
    {
        try {
            // Simulate processing, e.g., send email, integrate with external services, etc.
            // For now, just mark as processed
            $processedSubmission = new Submission(
                $this->submission->id(),
                $this->submission->formId(),
                $this->submission->payload(),
                $this->submission->schemaVersion(),
                $this->submission->schemaSnapshot(),
                SubmissionStatus::PROCESSED,
                $this->submission->createdAt()
            );

            $submissionRepository->save($processedSubmission);
        } catch (\Exception $e) {
            // Mark as failed
            $failedSubmission = new Submission(
                $this->submission->id(),
                $this->submission->formId(),
                $this->submission->payload(),
                $this->submission->schemaVersion(),
                $this->submission->schemaSnapshot(),
                SubmissionStatus::FAILED,
                $this->submission->createdAt()
            );

            $submissionRepository->save($failedSubmission);

            throw $e; // Re-throw to mark job as failed
        }
    }
}