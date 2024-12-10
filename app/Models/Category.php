<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être remplis via l'attribution de masse.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta',
        'category_id', // Si tu gères des sous-catégories
    ];

    /**
     * Indiquer que le champ "meta" est un tableau JSON.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];
}
