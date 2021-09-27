<?php

namespace Tests\Feature;

use Tests\TestCase;

class RoutesTest extends TestCase
{
    /** @test */
    public function adminDashboardGetRedirectThenSuccess()
    {
        $this->withoutMix();
        $response = $this->get('/admin/');
        $response->assertRedirect('/admin/login');

        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function clientsTableGetSuccess()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function billsPageGetSuccess()
    {
        $this->withoutMix();
        $response = $this->get('/admin/bills');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function clientsAddFormGetSuccess()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients/add-client');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function clientsEditFormGetNonexistentClientNotFound()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients/edit/-1');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function apiCategoryAllByServiceGetSuccess()
    {
        $this->withoutMix();
        $response = $this->get('/api/category/all-by-service/0');
        $response->assertRedirect('/admin/login');
    }
}
