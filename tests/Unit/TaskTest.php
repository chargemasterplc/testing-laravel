<?php

namespace Tests\Unit;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * @test
     */
    public function a_task_can_be_added()
    {
        factory(Task::class)->create();

        $tasks = Task::all();

        $this->assertEquals(1, count($tasks));
    }

    /**
     * @test
     */
    public function a_task_cannot_be_added_without_a_body()
    {
        new Task();
        $tasks = Task::all();

        $this->assertEmpty($tasks);
    }

    /**
     * @test
     */
    public function a_task_has_a_body()
    {
        $task = factory(Task::class)->create();

        $this->assertInternalType('string', $task->body);
    }

    /**
     * @test
     */
    public function a_task_is_not_complete_by_default()
    {
        $task = factory(Task::class)->create();

        $this->assertFalse($task->isComplete());
    }

    /**
     * @test
     */
    public function a_task_can_be_completed()
    {
        $task = factory(Task::class)->create();

        $task->complete();

        $this->assertTrue($task->isComplete());
    }
}
