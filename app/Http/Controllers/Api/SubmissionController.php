<?php

namespace App\Http\Controllers\Api;

use App\Application\Submission\UseCases\SubmitFormUseCase;
use App\Application\Submission\UseCases\ListSubmissionsUseCase;
use App\Application\Submission\UseCases\GetSubmissionDetailUseCase;
use App\Domain\Exceptions\DomainValidationException;
use App\Domain\Exceptions\FormNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SubmissionController extends Controller
{
    public function submit(int $id, Request $request, SubmitFormUseCase $submitUseCase): JsonResponse
    {
        try {
            $submission = $submitUseCase->execute($id, $request->all());

            return response()->json(['data' => $submission->toArray()], 201);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        } catch (DomainValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    public function index(ListSubmissionsUseCase $listUseCase): JsonResponse
    {
        $submissions = array_map(fn($submission) => $submission->toArray(), $listUseCase->execute());

        return response()->json(['data' => $submissions]);
    }

    public function show(int $id, GetSubmissionDetailUseCase $getUseCase): JsonResponse
    {
        try {
            $submission = $getUseCase->execute($id);

            return response()->json(['data' => $submission->toArray()]);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
}
