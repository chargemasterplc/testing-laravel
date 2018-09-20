<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorisationTest extends TestCase
{
    /**
     * @test
     */
    public function login_page_should_show_by_default()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function it_should_show_the_login_page_if_not_authorised()
    {
        $response = $this->get('/login');

        $response->assertSee(config('app.name'));
        $this->assertGuest();
    }
}
