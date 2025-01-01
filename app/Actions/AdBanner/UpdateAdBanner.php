<?php

namespace App\Actions\AdBanner;

use App\Models\AdBanner;

class UpdateAdBanner
{
    public function handle(AdBanner $adBanner, array $data): AdBanner
    {
        $adBanner->update($data);
        return $adBanner;
    }
}
