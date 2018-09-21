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

        $data = $response->getOriginalContent()->getData()['data']['tasks'];

        $this->assertEquals(count($tasks), count($data));
    }

    /**
     * @test
     */
    public function a_user_can_add_a_new_task()
    {
        $this->loginWithFakeUser();

        $task = [
            'body' => 'Do the shopping',
            'user_id' => self::USER_ID,
        ];

        $this->post('/tasks', $task);

        $user = Auth::user();
        $tasks = $user->tasks;

        $this->assertEquals(1, count($tasks));
    }

    /**
     * @test
     */
    public function a_user_can_complete_a_task()
    {
        $this->loginWithFakeUser();
        $tasks = factory(Task::class, 5)->create([
            'user_id' => self::USER_ID
        ]);
        $taskToBeCompleted = $tasks[0]->id;

        $this->post('/tasks/complete/' . $taskToBeCompleted);

        $task = Task::find($taskToBeCompleted);
        $this->assertTrue(boolval($task->completed));
    }
}
