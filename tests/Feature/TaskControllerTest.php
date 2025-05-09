<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_task()
    {
        $data = [
            'title' => 'New Task',
            'description' => 'Task description',
            'status' => 'pending',
            'due_date' => '05/01/2025',
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'title' => 'New Task',
                     'status' => 'pending',
                 ]);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    /** @test */
    public function it_validates_create_task()
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(400)
                 ->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function it_retrieves_all_tasks()
    {
        Task::factory()->count(2)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    /** @test */
    public function it_retrieves_a_task_by_id()
    {
        $task = Task::factory()->create();

        $response = $this->getJson('/api/tasks/' . $task->id);

        $response->assertStatus(200)
                 ->assertJson(['title' => $task->title]);
    }

    /** @test */
    public function it_returns_404_for_non_existent_task()
    {
        $response = $this->getJson('/api/tasks/999');

        $response->assertStatus(404)
                 ->assertJson(['error' => 'Task not found']);
    }

    /** @test */
    public function it_updates_task_status()
    {
        $task = Task::factory()->create();

        $response = $this->patchJson("/api/tasks/{$task->id}/status", ['status' => 'completed']);

        $response->assertStatus(200)
                 ->assertJson(['status' => 'completed']);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    /** @test */
    public function it_validates_status_update()
    {
        $task = Task::factory()->create();

        $response = $this->patchJson("/api/tasks/{$task->id}/status", ['status' => '']);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['status']);
    }

    /** @test */
    public function it_deletes_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}