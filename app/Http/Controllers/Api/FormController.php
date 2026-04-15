<?php

namespace App\Http\Controllers\Api;

use App\Application\UseCases\CreateFormUseCase;
use App\Application\UseCases\GetFormDetailUseCase;
use App\Application\UseCases\ListFormsUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
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
        $data = $request->validated();

        $form = $createUseCase->execute($data['title'], $data['status'], $data['fields']);

        return response()->json(['data' => $form->toArray()], 201);
    }

    public function show(int $id, GetFormDetailUseCase $getUseCase): JsonResponse
    {
        $form = $getUseCase->execute($id);

        return response()->json(['data' => $form->toArray()]);
    }
}
