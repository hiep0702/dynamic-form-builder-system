<?php

namespace App\Infrastructure\Submission\Repositories;

use App\Domain\Submission\Entities\Submission;
use App\Domain\Submission\Repositories\SubmissionRepositoryInterface;
use App\Infrastructure\Submission\Models\SubmissionModel;

final class EloquentSubmissionRepository implements SubmissionRepositoryInterface
{
    public function save(Submission $submission): Submission
    {
        $model = new SubmissionModel();
        $model->form_id = $submission->formId();
        $model->payload = $submission->payload();
        $model->save();

        return new Submission(
            $model->id,
            $model->form_id,
            $model->payload,
            $model->created_at ? new \DateTimeImmutable($model->created_at) : null,
        );
    }
}
