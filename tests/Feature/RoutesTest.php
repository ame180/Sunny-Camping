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
        $response->assertRedirect('/admin/login');

        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function clientsTable_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function billsPage_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/bills');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function clientsAddForm_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients/add-client');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function clientsEditForm_GetNonexistentClient_NotFound()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients/edit/-1');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function ApiCategoryAllByService_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/api/category/all-by-service/0');
        $response->assertRedirect('/admin/login');
    }
}
