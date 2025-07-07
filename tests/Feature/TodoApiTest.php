<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_fetch_authenticated_user_via_api()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->getJson('/api/user');
        $response->assertOk()
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
            ]);
    }

    public function test_user_can_create_todo()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson('/todo/task/create', [
            'name' => 'Test Task',
            'visibility' => 1,
        ]);
        $response->assertOk()->assertJsonFragment(['msg' => 'success']);
        $this->assertDatabaseHas('todos', [
            'name' => 'Test Task',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_update_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'name' => 'Old Task',
            'visibility' => 1,
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);
        $response = $this->postJson('/todo/task/update', [
            'taskid' => $todo->id,
            'name' => 'Updated Task',
            'visibility' => 2,
        ]);
        $response->assertOk()->assertJsonFragment(['msg' => 'success']);
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'name' => 'Updated Task',
            'visibility' => 2,
        ]);
    }

    public function test_user_can_change_todo_status()
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'name' => 'Status Task',
            'visibility' => 1,
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);
        $response = $this->postJson('/todo/task/update/status', [
            'taskid' => $todo->id,
            'status' => 1,
        ]);
        $response->assertOk()->assertJsonFragment(['msg' => 'success']);
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'status' => 1,
        ]);
    }

    public function test_user_can_delete_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'name' => 'Delete Task',
            'visibility' => 1,
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);
        $response = $this->postJson('/todo/task/destroy', [
            'taskid' => $todo->id,
        ]);
        $response->assertOk()->assertJsonFragment(['msg' => 'success']);
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }
}
