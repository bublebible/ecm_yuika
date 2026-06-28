<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_reports()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('admin.reports.index'));
        $response->assertStatus(403);

        $responseExport = $this->actingAs($user)->get(route('admin.reports.export'));
        $responseExport->assertStatus(403);
    }

    public function test_admin_can_access_reports_and_view_summary()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.reports.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.reports.index');
        $response->assertSee('Performance Report');
    }

    public function test_admin_can_export_reports_as_xlsx()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        // Create a completed rental to appear in the report
        $rental = Rental::create([
            'user_id' => $user->id,
            'status' => 'completed',
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
            'total_price' => 150000,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports.export', [
            'start_date' => now()->startOfMonth()->format('Y-m-d'),
            'end_date' => now()->endOfMonth()->format('Y-m-d'),
        ]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename="laporan-sewa-' . now()->startOfMonth()->format('Y-m-d') . '-to-' . now()->endOfMonth()->format('Y-m-d') . '.xlsx"');

        // Capture streamed response content
        ob_start();
        $response->sendContent();
        $output = ob_get_clean();

        // Check it is a valid ZIP/XLSX file by checking the magic bytes 'PK' (which XLSX files start with)
        $this->assertStringStartsWith('PK', $output);
    }
}
