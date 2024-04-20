<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => RolesEnum::Owner,
                'display_name' => RolesEnum::Owner->label(),
            ],
            [
                'name' => RolesEnum::Writer,
                'display_name' => RolesEnum::Writer->label(),
            ],
            [
                'name' => RolesEnum::Reviewer,
                'display_name' => RolesEnum::Reviewer->label(),
            ],
            [
                'name' => RolesEnum::Editor,
                'display_name' => RolesEnum::Editor->label(),
            ],
            [
                'name' => RolesEnum::SuperAdmin,
                'display_name' => RolesEnum::SuperAdmin->label(),
            ],
        ];

        Role::factory(count: count($roles))
            ->state(new Sequence(...$roles))
            ->create();
    }
}
