<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreWithValidData(): void
    {
        $user = User::factory()->create();
        $taskData = [
            'title' => 'Valid title',
            'description' => 'Valid description',
            'status' => 0,
        ];
        $this->actingAs($user)
            ->postJson('/api/tasks', $taskData)
            ->assertStatus(200)
            ->assertJson([
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'status' => $taskData['status'],
                'user_id' => $user->id,]);
 
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testStoreWithInvalidData(): void
    {
        $user = User::factory()->create();
        $taskData = [
            'title' => '',
            'description' => '',
            'status' => '',
        ];

        $this->actingAs($user)
            ->postJson('/api/tasks', $taskData)
            ->assertStatus(400)
            ->assertJson([
                'title' => ['The title field is required.'],
                'description' => ['The description field is required.'],
                'status' => ['The status field is required.'],
        ]);

        $this->assertDatabaseMissing('tasks', $taskData);
    }

    public function testUpdateWithValidData(): void
    {
        $user = User::factory()->create();
        $task = $user->tasks()->create([
            'title' => 'Valid title',
            'description' => 'Valid description',
            'status' => 0,
        ]);

        $taskData = [
            'title' => 'Updated title',
            'description' => 'Updated description',
            'status' => 1,
        ];
        
        $this->actingAs($user)
            ->putJson('/api/tasks/' . $task->id, $taskData)
            ->assertStatus(200)
            ->assertJson([
                'title' => $taskData['title'],
                'description' => $taskData['description'],
                'status' => $taskData['status'],
                'user_id' => $user->id,]);
            
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testUpdateWithInvalidData(): void
    {
        $user = User::factory()->create();
        $task = $user->tasks()->create([
            'title' => 'Valid title',
            'description' => 'Valid description',
            'status' => 0,
        ]);

        $taskData = [
            'title' => '',
            'description' => '',
            'status' => '',
        ];

        $this->actingAs($user)
            ->putJson('/api/tasks/' . $task->id, $taskData)
            ->assertStatus(400)
            ->assertJson([
                'title' => ['The title field is required.'],
                'description' => ['The description field is required.'],
                'status' => ['The status field is required.'],
            ]);

        $this->assertDatabaseMissing('tasks', $taskData);
    }

    public function testDelete(): void
    {
        $user = User::factory()->create();
        $task = $user->tasks()->create([
            'title' => 'Valid title',
            'description' => 'Valid description',
            'status' => 0,
        ]);

        $this->actingAs($user)
            ->deleteJson('/api/tasks/' . $task->id)
            ->assertStatus(200);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function testShow(): void
    {
        $user = User::factory()->create();
        $task = $user->tasks()->create([
            'title' => 'Valid title',
            'description' => 'Valid description',
            'status' => 0,
        ]);

        $this->actingAs($user)
            ->getJson('/api/tasks/' . $task->id)
            ->assertStatus(200)
            ->assertJson([
                'title' => $task->title,
            ]);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function testUpdateNotOwned(): void
    {
        $user = User::factory()->create();
        $task = $user->tasks()->create([
            'title' => 'Valid title',
            'description' => 'Valid description',
            'status' => 0,
        ]);

        $taskData = [
            'title' => 'Updated title',
            'description' => 'Updated description',
            'status' => 1,
        ];

        $this->actingAs(User::factory()->create())
            ->putJson('/api/tasks/' . $task->id, $taskData)
            ->assertStatus(403);
        
        $this->assertDatabaseMissing('tasks', $taskData);
    }


    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
