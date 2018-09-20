<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    private const USER_ID = 1;

    private function loginWithFakeUser()
    {
        $user = factory(User::class)->create([
            'id' => self::USER_ID,
        ]);

        $this->be($user);
    }

    /**
     * @test
     */
    public function it_should_display_tasks_of_current_user()
    {
        $this->loginWithFakeUser();

        $tasks = factory(Task::class, 3)->create([
            'user_id' => self::USER_ID,
        ]);

        $response = $this->get('/tasks');

        $data = $response->getOriginalContent();

        $this->assertEquals(count($tasks), count($data->tasks));
    }
}