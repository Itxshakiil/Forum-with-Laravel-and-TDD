<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function only_members_can_add_avatars()
    {
        $this->withExceptionHandling();

        $this->json('post', '/api/users/1/avatar')
        ->assertStatus(401);
    }

    /**
    * @test
    */
    public function a_valid_avatar_must_be_provided()
    {
        $this->withExceptionHandling();
        $this->actingAs(factory(User::class)->create());

        $this->json('post', '/api/users/' . auth()->id() . '/avatar', ['avatar' => 'not_A_image'])
        ->assertStatus(422);
    }

    /**
    * @test
    */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->actingAs(factory(User::class)->create());
        Storage::fake('public');

        $this->json('post', '/api/users/' . auth()->id() . '/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals('avatars/' . $file->hashName(), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
