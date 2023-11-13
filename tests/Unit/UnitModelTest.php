<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class UnitModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_subunits_relationship(): void
    {
        $parentUnit = Unit::factory()->create();

        $this->assertInstanceOf(Collection::class, $parentUnit->subUnits);
    }

    public function test_it_has_parent_relationship(): void
    {
        $parentUnit = Unit::factory()->create();
        $childUnit = Unit::factory()->create([
            'parent_id' => $parentUnit->id
        ]);

        $this->assertInstanceOf(Unit::class, $childUnit->unit);
    }

    public function test_paginate()
    {
        $units = Unit::factory()->count(5)->create();
        $page = Page::factory()->create();
        foreach ($units as $unit) {
            $unit->pages()->attach($page->id);
        }
        $paginator = Unit::paginate($page->id, null);
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals(5, $paginator->total());
        foreach ($paginator as $item) {
            $this->assertEquals($page->id, $item->pages->contains($page->id));
        }
        $this->assertEquals(5, $paginator[0]->id);
        $this->assertEquals(4, $paginator[1]->id);
        $this->assertEquals(3, $paginator[2]->id);
        $this->assertEquals(2, $paginator[3]->id);
        $this->assertEquals(1, $paginator[4]->id);
    }

    public function test_it_has_pages_relationship(): void
    {
        $unit = Unit::factory()->create();

        $this->assertInstanceOf(Collection::class, $unit->pages);
    }

    public function test_it_has_languages_relationship(): void {
        $unit = Unit::factory()->create();
        $this->assertInstanceOf(Collection::class, $unit->languages);
    }

}
