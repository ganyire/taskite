<?php

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;
use Laravel\Sanctum\Sanctum;
use Tests\RequestFactories\Task\CreateTaskRequestFactory;

/**
 * ----------------
 */
test('User can create a task', function () {
    $teamName = "Team Taskite";
    $user = registerUser(teamName: $teamName);
    Sanctum::actingAs($user);
    $project = createProject([
        'team_id' => $user->ownedTeam->id,
        'user_id' => $user->id,
    ]);
    CreateTaskRequestFactory::new ([
        'project_id' => $project->id,
    ])->fake();
    $response = postJson("{$this->baseUrl}/tasks");
    $response->assertCreated();
    $response->assertJsonPath('message', __('task.created'));
    $response->assertJsonPath('payload.project.name', $project->name);
    assertDatabaseCount('tasks', 1);
});

/**
 * ----------------
 */
test('User can not create a task with invalid data', function () {
    $teamName = "Team Taskite";
    $user = registerUser(teamName: $teamName);
    Sanctum::actingAs($user);
    $project = createProject([
        'team_id' => $user->ownedTeam->id,
        'user_id' => $user->id,
    ]);
    CreateTaskRequestFactory::new ([
        'name' => '',
        'project_id' => 'invalid' . $project->id,
    ])->fake();
    $response = postJson("{$this->baseUrl}/tasks");
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(
        ['name', 'project_id'],
        $this->apiValidationErrorsKey
    );
    assertDatabaseCount('tasks', 0);
});
