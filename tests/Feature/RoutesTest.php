<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    #[Test]
    public function adminDashboardGetRedirectThenSuccess()
    {
        $this->withoutVite();
        $response = $this->get('/admin/');
        $response->assertRedirect('/admin/login');

        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function clientsTableGetSuccess()
    {
        $this->withoutVite();
        $response = $this->get('/admin/clients');
        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function billsPageGetSuccess()
    {
        $this->withoutVite();
        $response = $this->get('/admin/bills');
        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function clientsAddFormGetSuccess()
    {
        $this->withoutVite();
        $response = $this->get('/admin/clients/add-client');
        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function clientsEditFormGetNonexistentClientNotFound()
    {
        $this->withoutVite();
        $response = $this->get('/admin/clients/edit/-1');
        $response->assertRedirect('/admin/login');
    }

    #[Test]
    public function apiCategoryAllByServiceGetSuccess()
    {
        $this->withoutVite();
        $response = $this->get('/api/categories?service_id=0');
        $response->assertRedirect('/admin/login');
    }
}
