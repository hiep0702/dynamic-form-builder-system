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
        $model->schema_version = $submission->schemaVersion();
        $model->schema_snapshot = $submission->schemaSnapshot();
        $model->status = $submission->status();
        $model->save();

        return new Submission(
            $model->id,
            $model->form_id,
            $model->payload,
            $model->schema_version,
            $model->schema_snapshot,
            $model->status,
            $model->created_at ? new \DateTimeImmutable($model->created_at) : null,
        );
    }

    public function find(int $id): ?Submission
    {
        $model = SubmissionModel::find($id);

        return $model ? $this->mapToEntity($model) : null;
    }

    public function all(): array
    {
        return SubmissionModel::all()->map(fn(SubmissionModel $submission) => $this->mapToEntity($submission))->all();
    }

    private function mapToEntity(SubmissionModel $model): Submission
    {
        return new Submission(
            $model->id,
            $model->form_id,
            $model->payload,
            $model->schema_version,
            $model->schema_snapshot,
            $model->status,
            $model->created_at ? new \DateTimeImmutable($model->created_at) : null,
        );
    }
}
