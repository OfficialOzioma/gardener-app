<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\User;
use App\Models\Gardener;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'location' => 'required',
            'country' => 'required|string|max:225',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $location = Location::where('location', 'iLIKE', '%' . $request->location . '%')->first();

        $allowed_countries = ['Nigeria', 'Kenya'];

        if (($location) && (in_array(ucfirst($request->country), $allowed_countries))) {

            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'location_id' => $location->id,
                'country' => $location->country,
            ]);

            $assign_gardener = Gardener::where('country', 'iLIKE', '%' . $user->country . '%')
                ->where('location_id', $user->location_id)
                ->inRandomOrder()
                ->first();

            if ($user) {

                $user->gardener_id = $assign_gardener->id;
                $user->save();

                $token = $user->createToken('gardenerApp')->accessToken;

                $getCustomer = User::where('id', $user->id)->with(['gardener'])->get();


                $response = [
                    'message' => 'Your account has been created, A gardener has been assigned to you',
                    'data' => CustomerResource::collection($getCustomer),
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

    public function getAllCustomers(Request $request)
    {
        $customers = Cache::remember('customers', 60, function () {
            return User::with(['gardener'])->get();
        });

        $response = [
            'message' => 'All customers',
            'data' => CustomerResource::collection($customers),
        ];

        return response($response, 200);
    }
}