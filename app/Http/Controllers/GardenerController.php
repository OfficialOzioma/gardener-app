<?php

namespace App\Http\Controllers;

use App\Models\Gardener;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\GardenerResource;
use Illuminate\Support\Facades\Validator;


class GardenerController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:gardeners',
            'location' => 'required',
            'country' => 'required|string|max:225',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $location = Location::where('location', 'iLIKE', '%' . $request->location . '%')->first();

        $allowed_countries = ['Nigeria', 'Kenya'];

        if ($location && in_array(ucfirst($request->country), $allowed_countries)) {

            $gardener = Gardener::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'location_id' => $location->id,
                'country' => $location->country,
            ]);


            if ($gardener) {

                $token = $gardener->createToken('gardenerApp')->accessToken;

                $getGardener = gardener::where('id', $gardener->id)->get();


                $response = [
                    'message' => 'Your account has been created, You are now one of our gardeners',
                    'data' => GardenerResource::collection($getGardener),
                    'Bearer token' => $token,
                ];

                return response($response, 200);
            }
        } else {
            $response = [
                'message' => 'This location is not allowed',
                'Allowed location Area' => 'Nairobi, Mombasa, Garissa, Abuja, Lagos, Owerri',
                'Allowed Countries' => 'Nigeria, Kenya',
            ];
            return response($response, 404);
        }
    }


    public function getGardeners($country)
    {

        $gardener = Cache::remember($country, '60', fn () => Gardener::where('country', 'iLIKE', '%' . $country . '%')->with('location')->get());

        if (count($gardener)) {
            $response = [
                'message' => 'All Gardeners from ' . strtoupper($country),
                'data' => GardenerResource::collection($gardener),
            ];
        } else {
            $response = [
                'message' => 'Sorry we dont have any gardener from ' . strtoupper($country),
            ];
        }

        return response($response, 200);
    }
}
