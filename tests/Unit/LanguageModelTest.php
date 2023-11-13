<?php

namespace Tests\Unit;

use App\Models\Appeal;
use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class LanguageModelTest extends TestCase
{

    use RefreshDatabase;

    public function test_it_has_units_relationship() {
        $language = Language::factory()
            ->create();
        $this->assertInstanceOf(Collection::class, $language->units);
    }


}
