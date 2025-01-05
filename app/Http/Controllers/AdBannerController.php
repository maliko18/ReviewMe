<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdBannerRequest;
use App\Http\Requests\UpdateAdBannerRequest;
use App\Models\AdBanner;
use App\Models\Place;
use App\Services\AdBannerService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdBannerController extends Controller
{
    protected AdBannerService $adBannerService;

    public function __construct(AdBannerService $adBannerService)
    {
        $this->adBannerService = $adBannerService;
    }

    public function index(): Response
    {
        $banners = $this->adBannerService->getBanners();
        $places = Place::select('id', 'name')->get();

        return Inertia::render('Admin/Banners/Index', [
            'banners' => $banners,
            'places' => $places,
        ]);
    }

    public function store(StoreAdBannerRequest $request): RedirectResponse
    {
        $this->adBannerService->storeBanner($request->validated(), $request->file('images'));

        return redirect()->back()->with('success', 'Banner created successfully');
    }

    public function update(UpdateAdBannerRequest $request, AdBanner $banner): RedirectResponse
    {
        $this->adBannerService->updateBanner($banner, $request->validated(), $request->file('images'));

        return redirect()->back()->with('success', 'Banner updated successfully');
    }

    public function destroy(AdBanner $banner): RedirectResponse
    {
        $this->adBannerService->deleteBanner($banner);

        return redirect()->back()->with('success', 'Banner deleted successfully');
    }
}
