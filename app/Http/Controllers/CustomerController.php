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
    /**
     * This method register a new customer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

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

    /**
     *  This method returns all the customers
     *  and also cache the response
     *
     * @return array
     */

    public function getAllCustomers()
    {
        $customers = Cache::remember('customers', 60, function () {
            return User::with(['gardener', 'location'])->get();
        });

        if (count($customers)) {
            $response = [
                'message' => 'All customers',
                'data' => CustomerResource::collection($customers),
            ];
        } else {
            $response = [
                'message' => 'Sorry we dont have any customer yet',
            ];
        }

        return response($response, 200);
    }

    /**
     *  Returns customers by their location
     *
     * @param string $location
     * @return array
     */

    public function getCustomersByLocation($location)
    {

        $customersbylocation = Cache::remember($location, 60, function ()  use ($location) {

            $getlocation = Location::where('location', 'iLIKE', '%' . $location . '%')
                ->orWhere('country', 'iLIKE', '%' . $location . '%')
                ->first();

            if ($getlocation) {
                return User::where('location_id', 'iLIKE', '%' . $getlocation->id . '%')->orWhere('country', 'iLIKE', '%' . $location . '%')->with(['location'])->get();
            } else {
                return false;
            }
        });

        if ($customersbylocation) {
            $response = [
                'message' => 'All customer from ' . strtoupper($location),
                'data' => CustomerResource::collection($customersbylocation),
            ];
        } else {
            $response = [
                'message' => 'Sorry, we dont have any customer from ' . strtoupper($location),
            ];
        }

        return response($response, 200);
    }
}