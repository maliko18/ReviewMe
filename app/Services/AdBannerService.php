<?php

namespace App\Services;

use App\Models\AdBanner;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdBannerService
{
    public function getBanners(): LengthAwarePaginator
    {
        return AdBanner::with(['place', 'images'])->latest()->paginate(10);
    }

    public function storeBanner(array $data, ?array $images): AdBanner
    {
        $banner = AdBanner::create($data);

        if ($images) {
            $this->storeImages($banner, $images);
        }

        return $banner;
    }

    private function storeImages(AdBanner $banner, array $images): void
    {
        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $path = $image->store('banners', 'public');
                $banner->images()->create([
                    'path' => $path,
                ]);
            }
        }
    }

    public function updateBanner(AdBanner $banner, array $data, ?array $images): AdBanner
    {
        $banner->update($data);

        if ($images) {
            $this->storeImages($banner, $images);
        }

        return $banner;
    }

    public function deleteBanner(AdBanner $banner): void
    {
        foreach ($banner->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $banner->delete();
    }
}
