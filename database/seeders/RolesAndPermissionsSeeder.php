<?php
// database/seeders/RolesAndPermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // Places
            'view places',
            'create places',
            'edit places',
            'delete places',
            'manage places',
            'manage place settings',

            // Reviews
            'create reviews',
            'edit reviews',
            'delete reviews',
            'manage reviews',
            'manage own reviews',

            // Categories
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'manage categories',

            // Events
            'view events',
            'create events',
            'edit events',
            'delete events',
            'manage events',

            // AdBanners
            'view ad_banners',
            'create ad_banners',
            'edit ad_banners',
            'delete ad_banners',
            'manage ad_banners',
            'manage place ad_banners',

            // Place Management
            'manage own place',
            'view place analytics',
            'manage place staff',
            'manage place events',
            'manage banners',

            // Admin
            'access admin panel',
            'manage users',
            'manage roles',
            'manage settings'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $placeAdmin = Role::create(['name' => 'place-admin']);
        $placeAdmin->givePermissionTo([
            'view places',
            'manage own place',
            'view place analytics',
            'manage place staff',
            'manage place events',
            'manage place ad_banners',
            'edit places',
            'delete places',
            'view events',
            'create events',
            'edit events',
            'delete events',
            'view ad_banners',
            'create ad_banners',
            'edit ad_banners',
            'delete ad_banners',
            'manage reviews'
        ]);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'view places',
            'view events',
            'create reviews',
            'edit reviews'
        ]);
    }
}
