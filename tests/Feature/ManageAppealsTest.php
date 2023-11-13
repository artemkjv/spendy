<?php

namespace Tests\Feature;

use App\Models\Appeal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageAppealsTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function test_a_user_can_view_a_appeal(){
        $user = User::factory()
            ->create();
        $appeal = Appeal::factory()
            ->create();
        $this
            ->actingAs($user)
            ->get(route('appeals.show', ['appeal' => $appeal->id]))
            ->assertOk()
            ->assertSee($appeal->phone)
            ->assertSee($appeal->first_name)
            ->assertSee($appeal->last_name)
            ->assertSee($appeal->email)
            ->assertSee($appeal->comment);
    }

    public function test_a_user_can_view_a_list_of_appeals() {
        $user = User::factory()
            ->create();
        $appeals = Appeal::factory(4)
            ->create();
        $this
            ->actingAs($user)
            ->get(route('appeals.index'))
            ->assertOk();
    }

}
