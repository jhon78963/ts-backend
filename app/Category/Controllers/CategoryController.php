<?php

namespace App\Category\Controllers;

use App\Category\Models\Category;
use App\Category\Requests\CategoryCreateRequest;
use App\Category\Requests\CategoryUpdateRequest;
use App\Category\Resources\CategoryResource;
use App\Category\Services\CategoryService;
use App\Shared\Controllers\Controller;
use App\Shared\Requests\GetAllRequest;
use App\Shared\Resources\GetAllCollection;
use App\Shared\Services\SharedService;
use App\Shared\Traits\HasAutocomplete;
use Illuminate\Http\JsonResponse;
use DB;

class CategoryController extends Controller
{
    use HasAutocomplete;
    protected CategoryService $categoryService;
    protected SharedService $sharedService;

    public function __construct(CategoryService $categoryService, SharedService $sharedService)
    {
        $this->categoryService = $categoryService;
        $this->sharedService = $sharedService;
    }

    public function create(CategoryCreateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $newCategory = $this->sharedService->convertCamelToSnake($request->validated());
            $category = $this->categoryService->create($newCategory);
            DB::commit();
            return response()->json([
                'message' => 'Category created.',
                'item' => [
                    'id' => $category->id,
                    'value' => $category->description
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Category $category): JsonResponse
    {
        DB::beginTransaction();
        try {
            $categoryValidated = $this->categoryService->validate($category, 'Category');
            $this->categoryService->delete($categoryValidated);
            DB::commit();
            return response()->json(['message' => 'Category deleted.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function get(Category $category): JsonResponse
    {
        $categoryValidated = $this->categoryService->validate($category, 'Category');
        return response()->json(new CategoryResource($categoryValidated));
    }

    public function getAutocomplete(Category $category): JsonResponse
    {
        return $this->autocomplete(
            $category,
            'categoryService',
            'Category'
        );
    }

    public function getAll(GetAllRequest $request): JsonResponse
    {
        $query = $this->sharedService->query(
            $request,
            'Category',
            'Category',
            ['id', 'description']
        );

        return response()->json(new GetAllCollection(
            CategoryResource::collection($query['collection']),
            $query['total'],
            $query['pages'],
        ));
    }

    public function getAllAutocomplete(GetAllRequest $request): JsonResponse
    {
        return $this->allAutocomplete(
            $request,
            'Brand',
            'Brand'
        );
    }

    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        DB::beginTransaction();
        try {
            $editCategory = $this->sharedService->convertCamelToSnake($request->validated());
            $categoryValidated = $this->categoryService->validate($category, 'Category');
            $this->categoryService->update($categoryValidated, $editCategory);
            DB::commit();
            return response()->json(['message' => 'Category updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
