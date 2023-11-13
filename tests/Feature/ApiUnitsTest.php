<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApiUnitsTest extends TestCase
{

    use RefreshDatabase;

    public function test_it_can_list_units()
    {
        $this->withoutExceptionHandling();
        $this->json('get', '/api/units')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    '*' => [
                        '*' => [
                            'id',
                            'uniq_id',
                            'text',
                            'file',
                            'parent_id',
                            'created_at',
                            'updated_at',
                            'languages' => '*',
                            'pages' => '*',
                            'sub_units' => '*'
                        ]
                    ]
                ]
            );
    }

    public function test_it_can_list_units_by_page()
    {
        $page = Page::factory()->create();
        $unit = Unit::factory()->create();
        $unit->pages()->attach($page->id);

        $this->json('get', "/api/units/page/$page->name")
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_it_can_show_unit()
    {
        $unit = Unit::factory()->create();
        $this->json('get', "/api/units/$unit->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'id' => $unit->id,
                    'uniq_id' => $unit->uniq_id,
                    'readable_name' => $unit->readable_name,
                    'sortable_id' => $unit->sortable_id,
                    'parent_id' => $unit->parent_id,
                    'created_at' => $unit->created_at,
                    'updated_at' => $unit->updated_at,
                ]
            );
    }

}
