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
                'name'         => RolesEnum::OWNER,
                'display_name' => RolesEnum::OWNER->label(),
            ],
            [
                'name'         => RolesEnum::WRITER,
                'display_name' => RolesEnum::WRITER->label(),
            ],
            [
                'name'         => RolesEnum::REVIEWER,
                'display_name' => RolesEnum::REVIEWER->label(),
            ],
            [
                'name'         => RolesEnum::EDITOR,
                'display_name' => RolesEnum::EDITOR->label(),
            ],
            [
                'name'         => RolesEnum::SUPER_ADMIN,
                'display_name' => RolesEnum::SUPER_ADMIN->label(),
            ],
        ];

        Role::factory(count: count($roles))
            ->state(new Sequence(...$roles))
            ->create();
    }
}
