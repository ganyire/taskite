<?php

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\patchJson;
use function PHPUnit\Framework\assertTrue;
use Laravel\Sanctum\Sanctum;
use Tests\RequestFactories\Auth\UpdateProfileRequestFactory;

test('Users can update their name', function () {
    $oldName = 'John Doe';
    $newName = 'Jane Doe';
    $user    = createBasicUser(['name' => $oldName]);
    Sanctum::actingAs($user);
    UpdateProfileRequestFactory::new ([
        'name' => $newName,
    ])->fake();

    $response = patchJson("{$this->baseUrl}/auth/profile");
    $user->refresh();
    $response->assertCreated();
    $response->assertJson([
        'message' => __('user.profile_updated'),
        'payload' => $newName,
    ]);
    assertDatabaseHas('users', [
        'id'   => $user->id,
        'name' => $newName,
    ]);
});

test('Users does not change if no new name is provided for the update',
    function () {
        $oldName = 'John Doe';
        $newName = '';
        $user    = createBasicUser(['name' => $oldName]);
        Sanctum::actingAs($user);
        UpdateProfileRequestFactory::new ([
            'name' => $newName,
        ])->fake();

        $response = patchJson("{$this->baseUrl}/auth/profile");
        $user->refresh();
        $response->assertCreated();
        $response->assertJson([
            'message' => __('user.profile_updated'),
        ]);
        assertTrue($user->name === $oldName);
    }
);
