<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManegePagesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_a_user_can_create_a_page(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $attributes = Page::factory()->raw();
        $this->actingAs($user);
        $this->get(route('pages.create'))
            ->assertOk();

        $this->post(route('pages.store'), $attributes);
        $this->assertDatabaseHas('pages', $attributes);
        $this->get(route('pages.index'))->assertSee($attributes['name']);
        $this->get(route('pages.index'))->assertSee($attributes['readable_name']);
    }

    public function test_user_can_view_page(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        $this->actingAs($user)
            ->get(route('pages.show', ['page' => $page->id]))
            ->assertOk()
            ->assertSee($page->readable_name);
    }

    public function test_a_page_requires_a_name(): void
    {
        $user = User::factory()->create();
        $attributes = Page::factory()
            ->raw(['name' => '']);

        $this->actingAs($user)->post(route('pages.store'), $attributes)
            ->assertSessionHasErrors('name');
    }

    public function test_a_guest_cannot_manage_page(): void
    {
        $this->get(route('pages.index'))
            ->assertRedirectToRoute('login');
        $page = Page::factory()->create();
        $this->get(route('pages.show', ['page' => $page->id]))
            ->assertRedirectToRoute('login');
        $this->get(route('pages.create'))
            ->assertRedirectToRoute('login');
        $this->get(route('pages.edit', ['page' => $page->id]))
            ->assertRedirectToRoute('login');
        $this->post(route('pages.store'), $page->toArray())
            ->assertRedirectToRoute('login');
        $this->put(route('pages.update', ['page' => $page->id]), $page->toArray())
            ->assertRedirectToRoute('login');
        $this->delete(route('pages.destroy', ['page' => $page->id]), $page->toArray())
            ->assertRedirectToRoute('login');
    }

    public function test_a_user_can_view_page_with_unit()
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();
        $unit = Unit::factory()->create([
            'readable_name' => 'parentUnit',
        ]);
        $unit->pages()->attach($page->id);


        foreach (
            $page->units as $unit
        )

        $this->actingAs($user)
            ->get(route('pages.show', ['page' => $page->id]))
            ->assertOk()
            ->assertSee( 'parentUnit', $unit->readable_name );
    }

    public function test_a_user_can_destroy_page()
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        $this->actingAs($user)
            ->delete(route('pages.destroy', ['page' => $page->id]))
            ->assertStatus(302)
            ->assertDontSee($page->name)
            ->assertDontSee($page->readable_name);
    }
}
