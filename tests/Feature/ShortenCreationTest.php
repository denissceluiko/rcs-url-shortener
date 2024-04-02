<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortenCreationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_shorten_url(): void
    {
        $response = $this
            ->post('/create', [
                'link' => 'http://delfi.lv',
            ]);


        $this->assertDatabaseHas('links', [
            'full_url' => 'http://delfi.lv',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');
    }

    /**
     * @test
     */
    public function can_shorten_url_with_custom_short_form(): void
    {
        $response = $this
            ->post('/create', [
                'link' => 'http://delfi.lv',
                'short' => 'delfi',
            ]);


        $this->assertDatabaseHas('links', [
            'full_url' => 'http://delfi.lv',
            'shortened_url' => 'delfi',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertSessionHas('status')
            ->assertRedirect('/');
    }

    /**
     * @test
     */
    public function will_not_duplicate_automatic_shortens(): void
    {
        Link::create([
            'full_url' => 'http://delfi.lv',
            'shortened_url' => Link::shorten('http://delfi.lv'),
        ]);

        $response = $this
            ->post('/create', [
                'link' => 'http://delfi.lv',
            ]);


        $this->assertDatabaseCount('links', 1);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');
    }
}
