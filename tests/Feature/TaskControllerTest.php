<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\StatusSeeder::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_task()
    {
        $data = [
            'title' => 'New Task',
            'description' => 'Task description',
            'status_id' => 1,
            'due_date' => now()->addDays(5)->format('j/n/Y')
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
                    ->assertJson([
                        'title' => 'New Task',
                        'status_id' => 1,
                    ]);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_create_task()
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422)
                    ->assertJsonValidationErrors(['title']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_retrieves_all_tasks()
    {
        Task::factory()->count(2)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                    ->assertJsonCount(2);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_retrieves_a_task_by_id()
    {
        $task = Task::factory()->create();

        $response = $this->getJson('/api/tasks/' . $task->id);

        $response->assertStatus(200)
                    ->assertJson(['title' => $task->title]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_404_for_non_existent_task()
    {
        $response = $this->getJson('/api/tasks/999');

        $response->assertStatus(404)
                    ->assertJson(['error' => 'Task not found']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_updates_task_status()
    {
        $task = Task::factory()->create();
        $completedStatusId = Status::where('status', 'Completed')->first()->id;

        $response = $this->patchJson("/api/tasks/{$task->id}/status", ['status_id' => $completedStatusId]);

        $response->assertStatus(200)
                    ->assertJson(['status_id' => $completedStatusId]);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status_id' => $completedStatusId]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_status_update()
    {
        $task = Task::factory()->create();

        $response = $this->patchJson("/api/tasks/{$task->id}/status", ['status_id' => '']);

        $response->assertStatus(422)
                    ->assertJsonValidationErrors(['status_id']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_deletes_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_fails_to_delete_non_existent_task()
    {
        $response = $this->deleteJson("/api/tasks/999");

        $response->assertStatus(404)
                    ->assertJson(['error' => 'Task not found']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_validates_due_date_format_on_create()
    {
        $data = [
            'title' => 'Invalid Due Date',
            'description' => 'Test',
            'status_id' => 1,
            'due_date' => 'invalid-date'
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(422)
                    ->assertJsonValidationErrors(['due_date']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_task_without_description()
    {
        $data = [
            'title' => 'Task Without Description',
            'status_id' => 1,
            'due_date' => now()->addDays(3)->format('j/n/Y')
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
                    ->assertJson([
                        'title' => 'Task Without Description',
                        'description' => null,
                    ]);

        $this->assertDatabaseHas('tasks', ['title' => 'Task Without Description']);
    }
}