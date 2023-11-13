<?php

namespace Tests\Feature;

use App\Models\Appeal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiAppealTest extends TestCase
{

    use RefreshDatabase;

    public function test_can_create_a_appeal()
    {
        $this->withoutExceptionHandling();
        $payload = Appeal::factory()
            ->raw();
        $this->json('post', '/api/appeals', $payload)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'surname',
                    'email',
                    'phone'
                ]
            ]);
    }

    public function test_a_appeal_requires_a_name()
    {
        $this->withoutExceptionHandling();
        $payload = Appeal::factory()
            ->raw(['name' => '']);
        $this->json('post', '/api/appeals', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_a_appeal_requires_a_surname()
    {
        $this->withoutExceptionHandling();
        $payload = Appeal::factory()
            ->raw(['surname' => '']);
        $this->json('post', '/api/appeals', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['surname']);
    }

    public function test_a_uniq_requires_a_email()
    {
        $this->withoutExceptionHandling();
        $payload = Appeal::factory()
            ->raw(['email' => '']);
        $this->json('post', '/api/appeals', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_a_appeal_requires_a_phone()
    {
        $this->withoutExceptionHandling();
        $payload = Appeal::factory()
            ->raw(['phone' => '']);
        $this->json('post', '/api/appeals', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }

}
