<?php

namespace App\Http\Controllers;

use App\Actions\AdBanner\CreateAdBanner;
use App\Http\Requests\AdBanner\StoreAdBannerRequest;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\AdBanner;



class AdBannerController extends Controller
{
    public function index(Place $place): JsonResponse
    {
        $adBanners = $place->adBanners()->get();

        return response()->json([
            'ad_banners' => $adBanners
        ]);
    }

    public function store(Place $place ,StoreAdBannerRequest $request ): JsonResponse

    {
        return response()->json([
            'ad_banners' => (new CreateAdBanner())->handle($place, $request->validated())
        ]);

    }

    public function show(Place $place, AdBanner $adBanner): JsonResponse
    {
        if ($adBanner->place_id !== $place->id) {
            return response()->json(['error' => 'Bannière non trouvée pour ce lieu'], 404);
        }

        return response()->json([
            'ad_banner' => $adBanner
        ]);
    }



    public function update(Request $request, Place $place, AdBanner $adBanner): JsonResponse
    {

        if ($adBanner->place_id !== $place->id) {
            return response()->json(['error' => 'Bannière non trouvée pour ce lieu'], 404);
        }

        return response()->json([
            'ad_banner' => update($request->all()),
            'message' => 'Bannière mise à jour avec succès'
        ]);
    }
    public function destroy(Place $place, AdBanner $adBanner): JsonResponse
    {
        // Vérifier que la bannière appartient bien à ce lieu
        if ($adBanner->place_id !== $place->id) {
            return response()->json(['error' => 'Bannière non trouvée pour ce lieu'], 404);
        }

        $adBanner->delete();

        return response()->json([
            'message' => 'Bannière supprimée avec succès'
        ]);
    }
}
