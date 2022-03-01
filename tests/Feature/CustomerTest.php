<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class CustomerTest extends TestCase
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

    public function testRegister()
    {
        $response = $this->json('POST', '/api/v1/customer/register', [
            'fullname'  => 'Test',
            'email'  =>  time() . 'test@example.com',
            'location'  =>   'Nairobi',
            'country'  =>  'Kenya',
        ]);

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);

        // Receive our token
        $this->assertArrayHasKey('Bearer token', $response->json());
    }

    public function testgetAllCustomers()
    {
        $token = $this->getAccessToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/v1/customers');

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);


        $response->assertStatus(200);
    }

    public function testgetCustomersByLocation()
    {
        $token = $this->getAccessToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/v1/customers/lagos');

        //Write the response in laravel.log
        Log::info(1, [$response->getContent()]);


        $response->assertStatus(200);
    }
}