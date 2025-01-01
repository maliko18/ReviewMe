<?php

namespace App\Actions\AdBanner;

use App\Models\AdBanner;

class GetAdBanner
{

    public function handle(int $id): ?AdBanner
    {
        return AdBanner::find($id);
    }

}
