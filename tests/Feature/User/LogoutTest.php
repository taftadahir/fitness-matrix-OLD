<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function logoutWithValidToken()
    {
        $user = User::factory()->withConfirmation()->make();
        $response = $this->postJson(route('user.register'), $user->getAttributes());
        $token = $response['token'];
        $logoutResp = $this->deleteJson(route('user.logout'), [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $logoutResp->assertStatus(200)->assertJsonFragment([
            'message' => trans('user.logout.success')
        ]);
    }

    /**
     * @test
     */
    public function logoutFromAllDevicesWithValidToken()
    {
        $user = User::factory()->withConfirmation()->make();
        $token = $this->postJson(route('user.register'), $user->getAttributes())['token'];

        $response = $this->deleteJson(route('user.logout_from_all_devices'), [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200)->assertJsonFragment([
            'message' => trans('user.logout_from_all_devices.success')
        ]);
    }

    /**
     * @test
     */
    public function logoutWithInValidToken()
    {
        $token = 'Invalid token';

        $response = $this->deleteJson(route('user.logout'), [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function logoutFromAllDevicesWithInValidToken()
    {
        $token = 'Invalid token';

        $response = $this->deleteJson(route('user.logout_from_all_devices'), [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertUnauthorized();
    }
}
