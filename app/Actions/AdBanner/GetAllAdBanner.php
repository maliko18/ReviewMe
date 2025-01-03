<?php

namespace App\Actions\AdBanner;
use App\Models\AdBanner;
use Illuminate\Database\Eloquent\Collection;

class GetAllAdBanner
{


    public function handle(): Collection
    {
        return AdBanner::all();
    }
}
