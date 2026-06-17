<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RentalFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_rental_lifecycle()
    {
        // 1. Setup Data
        $admin = User::factory()->create(['role' => 'admin', 'email' => 'admin@test.com']);
        $user = User::factory()->create(['role' => 'customer', 'email' => 'user@test.com', 'ktp_status' => 'verified']);
        
        $asset = Asset::create([
            'name' => 'Costume A',
            'code' => 'C001',
            'category' => 'Costume',
            'price_per_day' => 100000,
            'stock_qty' => 5,
        ]);
        
        // 2. User Browses Catalog
        $response = $this->actingAs($user)->get(route('user.catalog.index'));
        $response->assertStatus(200);
        $response->assertSee('Costume A');

        // 3. User Creates Rental
        $startDate = Carbon::tomorrow()->format('Y-m-d');
        $endDate = Carbon::tomorrow()->addDays(2)->format('Y-m-d'); // 3 days
        
        $response = $this->actingAs($user)->post(route('user.rentals.store'), [
            'asset_id' => $asset->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'qty' => 1,
        ]);
        
        $response->assertRedirect(route('user.rentals.index'));
        $this->assertDatabaseHas('rentals', ['user_id' => $user->id, 'status' => 'pending']);
        $rental = Rental::first();

        // 6. Admin Approves Rental
        $response = $this->actingAs($admin)->put(route('admin.rentals.update', $rental), [
            'approve_rental' => 1,
        ]);
        
        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'status' => 'approved']);

        // 7. User Downloads Contract
        $response = $this->actingAs($user)->get(route('user.rentals.contract', $rental));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        // 8. Admin Starts Rental (Barang Diambil)
        $response = $this->actingAs($admin)->put(route('admin.rentals.update', $rental), [
            'start_rental' => 1,
        ]);
        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'status' => 'active']);

        // 9. User Returns (Upload Proof)
        $fileReturn = UploadedFile::fake()->image('return.jpg');
        $response = $this->actingAs($user)->put(route('user.rentals.update', $rental), [
            'return_proof' => $fileReturn,
        ]);
        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'status' => 'returned']);

        // 10. Admin Archives
        $response = $this->actingAs($admin)->put(route('admin.rentals.update', $rental), [
            'complete_rental' => 1,
        ]);
        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'status' => 'completed']);
    }
}
