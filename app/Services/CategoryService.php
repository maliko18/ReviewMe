<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryService
{
    /**
     * Get paginated and filtered categories.
     *
     * @return mixed
     */
    public function getCategories()
    {
        return QueryBuilder::for(Category::class)
          /*  ->allowedFilters([
                'search' => fn($query, $value) => $query->where('name', 'like', "%{$value}%"),
            ])*/
            ->withCount('places')
            ->paginate()
            ->withQueryString();
    }

    /**
     * Store a new category.
     *
     * @param array $data
     * @return Category
     */
    public function storeCategory(array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        return Category::create($data);
    }

    /**
     * Update an existing category.
     *
     * @param Category $category
     * @param array $data
     * @return Category
     */
    public function updateCategory(Category $category, array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);

        return $category;
    }

    /**
     * Delete a category.
     *
     * @param Category $category
     * @return bool
     */
    public function deleteCategory(Category $category): bool
    {
        if ($category->categories()->exists()) {
            throw new \Exception('Cannot delete category with subcategories.');
        }

        return $category->delete();
    }
}
