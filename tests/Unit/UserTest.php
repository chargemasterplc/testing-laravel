<?php

namespace Tests\Unit;

use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function a_user_can_be_added()
    {
        factory(User::class)->create();

        $users = User::all();

        $this->assertEquals(1, count($users));
    }

    /**
     * @test
     */
    public function a_user_must_have_a_name()
    {
        new User([
            'email' => 'test@example.com'
        ]);

        $users = User::all();

        $this->assertEquals(0, count($users));
    }

    /**
     * @test
     */
    public function a_user_must_have_an_email()
    {
        new User([
           'name' => 'John Smith'
        ]);

        $users = User::all();

        $this->assertEquals(0, count($users));
    }

    /**
     * @test
     */
    public function a_user_can_have_several_tasks()
    {
        $user = factory(User::class)->create();
        $tasks = factory(Task::class, 3)->create([
            'user_id' => $user->id
        ]);

        $userTasks = User::find($user->id)->tasks;

        $this->assertEquals(count($tasks), count($userTasks));
    }
}
