<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{

    public function getLocations()
    {
        $location = Cache::remember('location', '60', fn () => Location::with(['customers'])->get());

        if (count($location) == 0) {
            $response = [
                'message' => 'Sorry No location available',
            ];
        }

        $response = [
            'message' => "List of Available Locations",
            'data' => LocationResource::collection($location),
        ];

        return response($response, 200);
    }
}
