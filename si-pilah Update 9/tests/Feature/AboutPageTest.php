<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\AboutSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_about_page_can_be_accessed(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
    }

    public function test_admin_about_page_can_be_accessed_and_updated_by_admin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Seed some defaults first
        AboutSetting::create([
            'section' => 'hero',
            'key' => 'title',
            'value' => 'Old Title'
        ]);

        // 1. Access admin page
        $response = $this->actingAs($admin)
            ->get('/admin/about');

        $response->assertStatus(200);

        // 2. Submit update to about
        $response = $this->actingAs($admin)
            ->post('/admin/about', [
                'section' => 'hero',
                'hero_title' => 'New Title',
            ]);

        $response->assertStatus(302);
        
        $this->assertDatabaseHas('about_settings', [
            'section' => 'hero',
            'key' => 'title',
            'value' => 'New Title'
        ]);
    }
}
