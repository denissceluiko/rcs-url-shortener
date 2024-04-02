<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_shorten_url_with_custom_short_form(): void
    {

        Link::create([
            'full_url' => 'http://delfi.lv',
            'shortened_url' => 'delfi',
        ]);

        $response = $this->get('/delfi');

        $response
            ->assertRedirect('http://delfi.lv');

        $this->assertDatabaseHas('links', [
            'full_url' => 'http://delfi.lv',
            'shortened_url' => 'delfi',
            'clicks' => 1,
        ]);
    }
}
