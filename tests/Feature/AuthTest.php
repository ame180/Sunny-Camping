<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function api_WithoutUser_Redirect()
    {
        $this->withoutMix();
        $response = $this->get('/api/category/all-by-service/0');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function admin_WithoutUser_Redirect()
    {
        $this->withoutMix();
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('admin/login');
    }
}
