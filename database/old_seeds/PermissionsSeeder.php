<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'excursions' => [
                'booking-view',
                'content-edit',
                'meta-edit',
                'details-edit',
                'options-edit',
                'calendar-edit',
            ],
            'tours' => [
                'booking-view',
                'content-edit',
                'meta-edit',
                'details-edit',
                'options-edit',
                'calendar-edit',
                'accommodations-edit',
            ],
            'billing' => [
                'payments-view',
                'index-view',
            ],
            'users' => [
                'index-view',
                'profile-edit',
            ],
            'settings' => [
                'places-edit',
                'options-edit',
            ],
            'cms' => [
                'edit'
            ]
        ];


        foreach ($permissions as $sys => $perms) {
            foreach ($perms as $perm) {
                \App\Permission::create([
                    'name' => $sys . '-' . $perm,
                    'display_name' => $sys . '-' . $perm,
                ]);
            }
        }


        $roles = [
            ['name' => 'staff', 'display_name' => 'Staff'],
            ['name' => 'seo', 'display_name' => 'Seoshnink']
        ];

        foreach ($roles as $role) {
            \App\Role::create($role);

        }
    }
}
