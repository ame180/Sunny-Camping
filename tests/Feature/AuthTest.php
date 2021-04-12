<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function api_WithoutUser_Redirect()
    {
        $this->withoutMix();
        config()->set('features.auth', true);
        $response = $this->get('/api/category/all-by-service/0');
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function admin_WithoutUser_Redirect()
    {
        $this->withoutMix();
        config()->set('features.auth', true);
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('home'));
    }
}
