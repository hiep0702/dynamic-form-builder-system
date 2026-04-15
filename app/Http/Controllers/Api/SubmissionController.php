<?php

namespace App\Http\Controllers\Api;

use App\Application\Submission\UseCases\SubmitFormUseCase;
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
}
