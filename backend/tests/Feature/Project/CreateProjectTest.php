<?php

use App\Enums\ProjectStatus;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;
use Laravel\Sanctum\Sanctum;
use Tests\RequestFactories\Project\CreateProjectRequestFactory;

test('User can create a project', function () {
    $user = registerUser('Team Taskite', 'Taskite123!');
    Sanctum::actingAs($user);
    $projectName = 'Project Taskite';
    $team        = $user->ownedTeam->name;
    CreateProjectRequestFactory::new ([
        'name' => $projectName,
        'team' => $team,
    ])->fake();
    $response = postJson("{$this->baseUrl}/projects");

    $response->assertCreated();
    $response->assertJsonPath('message', __('project.created'));
    $response->assertJsonPath('payload.status', ProjectStatus::Pending->value);
    assertDatabaseHas('projects', [
        'name'    => $projectName,
        'team_id' => $user->ownedTeam->id,
        'user_id' => $user->id,
    ]);
});

test('User cannot create a project with invalid team', function () {
    $user = registerUser('Team Taskite', 'Taskite123!');
    Sanctum::actingAs($user);
    $projectName = 'Project Taskite';
    $team        = 'Invalid Team';
    CreateProjectRequestFactory::new ([
        'name' => $projectName,
        'team' => $team,
    ])->fake();
    $response = postJson("{$this->baseUrl}/projects");

    $response->assertStatus(422);
    $response->assertJsonPath('payload', __('app.model_missing', ['model' => 'Team']));
    assertDatabaseMissing('projects', [
        'name' => $projectName,
    ]);
});
