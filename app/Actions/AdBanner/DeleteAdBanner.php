<?php

namespace App\Actions\AdBanner;

use App\Models\AdBanner;

class DeleteAdBanner
{
    public function handle( AdBanner $adBanner): ?bool
    {
        return $adBanner->delete();
    }
}
