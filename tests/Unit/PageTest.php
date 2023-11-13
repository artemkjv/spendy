<?php

namespace Tests\Unit;

use App\Models\Page;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_unit_relationship(): void
    {
        $page = Page::factory()->create();

        $this->assertInstanceOf( Collection::class, $page->units);
    }

    public function test_paginate()
    {
        Page::factory()->count(5)->create();
        $paginator = Page::paginate();
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals(5, $paginator->total());
        $this->assertEquals(5, $paginator[0]->id);
        $this->assertEquals(4, $paginator[1]->id);
        $this->assertEquals(3, $paginator[2]->id);
        $this->assertEquals(2, $paginator[3]->id);
        $this->assertEquals(1, $paginator[4]->id);
    }

}
