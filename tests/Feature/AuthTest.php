<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthTest extends TestCase
{
    #[Test]
    public function apiWithoutUserRedirect()
    {
        $this->withoutVite();
        $response = $this->get('/api/categories?service_id=0');
        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function adminWithoutUserRedirect()
    {
        $this->withoutVite();
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('admin/login');
    }
}
