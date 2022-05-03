<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function apiWithoutUserRedirect()
    {
        $this->withoutMix();
        $response = $this->get('/api/categories?service_id=0');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function adminWithoutUserRedirect()
    {
        $this->withoutMix();
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('admin/login');
    }
}
