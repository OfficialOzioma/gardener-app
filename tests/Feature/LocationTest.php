<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{
    /**
     * generate access token.
     *
     * @return void
     */
    protected function getAccessToken()
    {
        $user = User::create([
            'fullname' => 'My Test',
            'email' => rand(12345, 678910) . 'test@gmail.com',
            'location_id' => '1',
            'country' => 'Kenya',
        ]);

        return $user->createToken('authToken')->accessToken;
    }

    public function testgetLocations()
    {
        $token = $this->getAccessToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/v1/locations');

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);


        $response->assertStatus(200);

        // Receive our token
        // $this->assertArrayHasKey('data', $response->json());
    }
}