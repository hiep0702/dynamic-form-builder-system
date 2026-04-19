<?php

namespace App\Http\Controllers\Api;

use App\Application\Form\UseCases\CreateFormUseCase;
use App\Application\Form\UseCases\UpdateFormUseCase;
use App\Application\Form\UseCases\GetFormDetailUseCase;
use App\Application\Form\UseCases\ListFormsUseCase;
use App\Application\Form\UseCases\DeleteFormUseCase;
use App\Domain\Exceptions\FormNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use Illuminate\Http\JsonResponse;

final class FormController extends Controller
{
    public function index(ListFormsUseCase $listUseCase): JsonResponse
    {
        $forms = array_map(fn($form) => $form->toArray(), $listUseCase->execute());

        return response()->json(['data' => $forms]);
    }

    public function store(StoreFormRequest $request, CreateFormUseCase $createUseCase): JsonResponse
    {
        $form = $createUseCase->execute($request->toCommand());

        return response()->json(['data' => $form->toArray()], 201);
    }

    public function show(int $id, GetFormDetailUseCase $getUseCase): JsonResponse
    {
        try {
            $form = $getUseCase->execute($id);

            return response()->json(['data' => $form->toArray()]);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }

    public function update(int $id, UpdateFormRequest $request, UpdateFormUseCase $updateUseCase): JsonResponse
    {
        $command = $request->toCommand($id);

        try {
            $form = $updateUseCase->execute($command);

            return response()->json(['data' => $form->toArray()]);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }

    public function destroy(int $id, DeleteFormUseCase $deleteUseCase): JsonResponse
    {
        try {
            $deleteUseCase->execute($id);

            return response()->json(['message' => 'Form deleted successfully']);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
}
