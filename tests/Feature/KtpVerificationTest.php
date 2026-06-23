<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KtpVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_verify_user_ktp()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer', 'ktp_status' => 'pending']);

        $response = $this->actingAs($admin)
            ->post(route('admin.ktp.verify', $customer));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'ktp_status' => 'verified',
            'ktp_rejection_reason' => null
        ]);
    }

    public function test_admin_can_reject_user_ktp()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer', 'ktp_status' => 'pending']);

        $response = $this->actingAs($admin)
            ->post(route('admin.ktp.reject', $customer), [
                'rejection_reason' => 'KTP tidak terbaca jelas'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'ktp_status' => 'rejected',
            'ktp_rejection_reason' => 'KTP tidak terbaca jelas'
        ]);
    }
}
