<?php

namespace App\Http\Controllers\Api;

use App\Application\Form\UseCases\CreateFormUseCase;
use App\Application\Form\UseCases\UpdateFormUseCase;
use App\Application\Form\UseCases\GetFormDetailUseCase;
use App\Application\Form\UseCases\ListFormsUseCase;
use App\Application\Form\UseCases\DeleteFormUseCase;
use App\Application\Form\UseCases\AddFieldToFormUseCase;
use App\Application\Form\UseCases\UpdateFieldUseCase;
use App\Application\Form\UseCases\RemoveFieldFromFormUseCase;
use App\Application\Form\UseCases\ListActiveFormsUseCase;
use App\Application\Form\UseCases\GetActiveFormDetailUseCase;
use App\Domain\Exceptions\FormNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function addField(int $id, Request $request, AddFieldToFormUseCase $addFieldUseCase): JsonResponse
    {
        try {
            $form = $addFieldUseCase->execute($id, $request->all());

            return response()->json(['data' => $form->toArray()]);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }

    public function updateField(int $formId, int $fieldId, Request $request, UpdateFieldUseCase $updateFieldUseCase): JsonResponse
    {
        try {
            $form = $updateFieldUseCase->execute($formId, $fieldId, $request->all());

            return response()->json(['data' => $form->toArray()]);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }

    public function removeField(int $formId, int $fieldId, RemoveFieldFromFormUseCase $removeFieldUseCase): JsonResponse
    {
        try {
            $form = $removeFieldUseCase->execute($formId, $fieldId);

            return response()->json(['data' => $form->toArray()]);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }

    public function activeForms(ListActiveFormsUseCase $listActiveUseCase): JsonResponse
    {
        $forms = array_map(fn($form) => $form->toArray(), $listActiveUseCase->execute());

        return response()->json(['data' => $forms]);
    }

    public function activeFormDetail(int $id, GetActiveFormDetailUseCase $getActiveUseCase): JsonResponse
    {
        try {
            $form = $getActiveUseCase->execute($id);

            return response()->json(['data' => $form->toArray()]);
        } catch (FormNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
}
