<?php

namespace App\Http\Controllers;

use App\Actions\Category\DeleteCategory;
use App\Actions\Category\GetAllCategories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Récupérer toutes les catégories.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json((new GetAllCategories())->handle());
    }

    /**
     * Créer une nouvelle catégorie ou sous-catégorie.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'meta' => 'nullable|array',
            'category_id' => 'nullable|exists:categories,id', // ID du parent pour les sous-catégories
        ]);

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'category' => $category,
        ]);
    }

    /**
     * Supprimer une catégorie.
     *
     * @param \App\Models\Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        return response()->json([
            'status' =>(new DeleteCategory())->handle($category)
        ]);
    }
}
