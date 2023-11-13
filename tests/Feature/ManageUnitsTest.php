<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\Page;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageUnitsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_a_user_can_create_a_unit()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $attributes = Unit::factory()
            ->raw();
        $pages = Page::factory(2)->create()
            ->pluck('id')->toArray();
        $attributes['pages'] = $pages;
        $this->actingAs($user);
        Language::factory(10)->create();
        $this->get(route('units.create'))
            ->assertOk();
        $this->post(route('units.store'), $attributes);
        unset($attributes['pages']);
        $this->assertDatabaseHas('units', $attributes);
        $this->get(route('units.index'))->assertSee($attributes['uniq_id']);
        $this->get(route('units.index'))->assertSee($attributes['readable_name']);
    }

    public function test_a_unit_requires_a_uniq_id()
    {
        $attributes = Unit::factory()
            ->raw(['uniq_id' => '']);
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('units.store'), $attributes)
            ->assertSessionHasErrors('uniq_id');
    }

    public function test_a_unit_requires_a_pages() {
        $user = User::factory()->create();
        $attributes = Unit::factory()
            ->raw(['pages' => '']);
        $this->actingAs($user)
            ->post(route('units.store'), $attributes)
            ->assertSessionHasErrors('pages');
    }

    public function test_a_guest_cannot_manage_units() {
        $this->get(route('units.index'))
            ->assertRedirectToRoute('login');
        $unit = Unit::factory()->create();
        $this->get(route('units.show', ['unit' => $unit->id]))
            ->assertRedirectToRoute('login');
        $this->get(route('units.create'))
            ->assertRedirectToRoute('login');
        $this->get(route('units.edit', ['unit' => $unit->id]))
            ->assertRedirectToRoute('login');
        $this->post(route('units.store'), $unit->toArray())
            ->assertRedirectToRoute('login');
        $this->put(route('units.update', ['unit' => $unit->id]), $unit->toArray())
            ->assertRedirectToRoute('login');
        $this->delete(route('units.destroy', ['unit' => $unit->id]), $unit->toArray())
            ->assertRedirectToRoute('login');
    }

    public function test_a_user_can_view_unit() {
        $user = User::factory()->create();
        $unit = Unit::factory()->create();
        $this->actingAs($user)
            ->get(route('units.show', ['unit' => $unit->id]))
            ->assertOk()
            ->assertSee($unit->readable_name)
            ->assertSee($unit->text);
    }

    public function test_a_user_can_view_child_unit()
    {
        $user = User::factory()->create();
        $parentUnit = Unit::factory()->create();
        $childUnit = Unit::factory()->create([
            'parent_id' => $parentUnit->id,
        ]);

        $this->actingAs($user)
            ->get(route('units.show', ['unit' => $parentUnit->id]))
            ->assertOk()
            ->assertSee($childUnit->readable_name);
    }

    public function test_a_user_can_destroy_unit()
    {
        $user = User::factory()->create();
        $parentUnit = Unit::factory()->create();

        $this->actingAs($user)
            ->delete(route('units.destroy', ['unit' => $parentUnit->id]))
            ->assertStatus(302)
            ->assertDontSee($parentUnit->readable_name)
            ->assertDontSee($parentUnit->uniq_id);
    }

    public function test_a_user_can_filter_unit()
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();
        $firstUnit = Unit::factory()->create();
        $firstUnit->pages()->attach($page->id);
        $secondUnit = Unit::factory()->create([
            'parent_id' => $page->id,
        ]);

        $this->actingAs($user)
            ->get(route('units.index'). '?page_id='. $page->id)
            ->assertOk()
            ->assertSee($firstUnit->uniq_id)
            ->assertDontSee($secondUnit->uniq_id);
    }
}
