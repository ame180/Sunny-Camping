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
        dump($response->content());
        $response->assertRedirect();

        $response = $this->get('/admin/dashboard');
        dump($response->content());
        $response->assertOk();
    }

    /** @test */
    public function clientsTable_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients');
        dump($response->content());
        $response->assertOk();
    }

    /** @test */
    public function billsPage_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/bills');
        dump($response->content());
        $response->assertOk();
    }

    /** @test */
    public function clientsAddForm_Get_Success()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients/add-client');
        dump($response->content());
        $response->assertOk();
    }

    /** @test */
    public function clientsEditForm_GetNonexistentClient_NotFound()
    {
        $this->withoutMix();
        $response = $this->get('/admin/clients/edit/-1');
        dump($response->content());
        $response->assertNotFound();
    }
}
