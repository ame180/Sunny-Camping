<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /** @test */
    public function adminDashboard_Get_RedirectThenSuccess()
    {
        $this->withoutMix();
        $response = $this->get('/admin/');
        $response->assertRedirect();

        $response = $this->get('/admin/dashboard');
        $response->assertOk();
    }

    /** @test */
    public function clientsTable_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients');
        $response->assertOk();
    }

    /** @test */
    public function billsPage_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/bills');
        $response->assertOk();
    }

    /** @test */
    public function clientsAddForm_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients/add-client');
        $response->assertOk();
    }

    /** @test */
    public function clientsEditForm_GetNonexistentClient_NotFound()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients/edit/-1');
        $response->assertNotFound();
    }

    /** @test */
    public function ApiCategoryAllByService_Get_Success()
    {
        $this->withoutMix();
        config()->set('features.auth', false);
        $response = $this->get('/api/category/all-by-service/0');
        $response->assertOk();
    }
}
