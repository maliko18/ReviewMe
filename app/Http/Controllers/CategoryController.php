<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters([
                AllowedFilter::callback('search', fn($query, $value) => $query->where('name', 'like', "%{$value}%")
                )
            ])
            ->withCount('places')
            ->paginate()
            ->withQueryString();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function update( Category $category,StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->categories()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete category with subcategories');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
