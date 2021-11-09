<?php

namespace Tests\Feature;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_adopt_own()
    {
        $user = User::factory()->create();
        $adoption = Adoption::factory()->create([
            'listed_by' => $user->id
        ]);

        $this->followingRedirects()
            ->actingAs($user)
            ->post("/adoptions/$adoption->id/adopt")
            ->assertForbidden();

        $user2 = User::factory()->create();
        $adoption2 = Adoption::factory()->create([
            'listed_by' => $user2->id
        ]);
        $this->followingRedirects()
            ->actingAs($user)
            ->post("/adoptions/$adoption2->id/adopt")
            ->assertSuccessful();
    }
}
