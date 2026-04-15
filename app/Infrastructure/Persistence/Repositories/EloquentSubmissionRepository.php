<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Submission;
use App\Domain\Repositories\SubmissionRepositoryInterface;
use App\Infrastructure\Persistence\Models\SubmissionModel;

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
