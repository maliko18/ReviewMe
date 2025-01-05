<?php

namespace App\Actions\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class GetAllCategories
{
    public function handle(): Collection
    {
        return  Category::all();
    }
}
