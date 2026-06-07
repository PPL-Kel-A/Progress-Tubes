<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Waste;
use App\Models\Reward;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WasteClaimTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_claim_points_once_and_cannot_claim_again(): void
    {
        $user = User::factory()->create(['points' => 0]);
        $waste = Waste::create([
            'user_id' => $user->id,
            'name' => 'Sampah Dapur',
            'type' => 'organic',
            'category' => 'Makanan',
            'weight' => 5.0,
            'tps' => 'TPS Kebon Jeruk',
            'image' => 'wastes/test.jpg',
            'result' => 2.5,
            'status' => 'Selesai',
        ]);

        $this->assertFalse($waste->is_claimed);

        // 1. Claim points first time via json/ajax
        $response = $this->actingAs($user)
            ->postJson("/waste/claim-point/{$waste->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // Points should be awarded (result * 10 = 25)
        $user->refresh();
        $this->assertEquals(25, $user->points);

        // Waste model should reflect claimed status
        $waste->refresh();
        $this->assertTrue($waste->is_claimed);

        // A Reward log should be created
        $this->assertDatabaseHas('rewards', [
            'user_id' => $user->id,
            'points' => 25,
            'type' => 'setor',
        ]);

        // 2. Claim points second time should fail
        $response = $this->actingAs($user)
            ->postJson("/waste/claim-point/{$waste->id}");

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Poin untuk pengajuan ini sudah diklaim.'
            ]);
    }
}
