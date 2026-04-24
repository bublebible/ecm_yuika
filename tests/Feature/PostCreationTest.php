<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_post_and_user_can_view_it()
    {
        // 1. Setup
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'customer']);
        
        Storage::fake('public');
        $image = UploadedFile::fake()->image('post.jpg');

        // 2. Admin Creates Post
        $response = $this->actingAs($admin)->post(route('admin.content.store'), [
            'title' => 'Tips Merawat Kostum',
            'content' => 'Ini adalah konten tips...',
            'image' => $image,
            'is_published' => 1,
        ]);

        $response->assertRedirect(route('admin.content.index'));
        $this->assertDatabaseHas('posts', ['title' => 'Tips Merawat Kostum']);
        $post = Post::first();

        // 3. User Views Blog Index
        $response = $this->actingAs($user)->get(route('user.blog.index'));
        $response->assertStatus(200);
        $response->assertSee('Tips Merawat Kostum');

        // 4. User Views Post Detail
        $response = $this->actingAs($user)->get(route('user.blog.show', $post->slug));
        $response->assertStatus(200);
        $response->assertSee('Ini adalah konten tips...');
    }
}
