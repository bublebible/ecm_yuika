<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ConditionImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_condition_image()
    {
        // 1. Setup
        $admin = User::factory()->create(['role' => 'admin']);
        $asset = Asset::create([
            'name' => 'Iron Man Suit',
            'code' => 'IM-001',
            'category' => 'Costume',
            'price_per_day' => 150000,
            'stock_qty' => 1
        ]);
        
        Storage::fake('public');
        $image = UploadedFile::fake()->image('damage.jpg');
        $wigImage = UploadedFile::fake()->image('wig.jpg');
        $accImage = UploadedFile::fake()->image('acc.jpg');

        // 2. Admin Updates Condition with Image
        $response = $this->actingAs($admin)->put(route('admin.assets.update', $asset), [
            'new_version' => 1,
            'status' => 'Damaged',
            'notes' => 'Scratch on the helmet',
            'image' => $image,
            'wig_image' => $wigImage,
            'acc_image' => $accImage,
        ]);

        $response->assertSessionHas('success');
        
        // 3. Verify Database and Storage
        $this->assertDatabaseHas('asset_conditions', [
            'asset_id' => $asset->id,
            'status' => 'Damaged',
            'notes' => 'Scratch on the helmet',
        ]);

        $condition = $asset->conditions()->latest()->first();
        $this->assertNotNull($condition->image);
        $this->assertNotNull($condition->wig_image);
        $this->assertNotNull($condition->acc_image);
        
        Storage::disk('public')->assertExists($condition->image);
        Storage::disk('public')->assertExists($condition->wig_image);
        Storage::disk('public')->assertExists($condition->acc_image);
    }
}
