<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view all tickets']);
        Permission::create(['name' => 'view my tickets']);
        Permission::create(['name' => 'create ticket']);
        Permission::create(['name' => 'edit ticket']);
        Permission::create(['name' => 'delete ticket']);

        Permission::create(['name' => 'assign ticket']);
        Permission::create(['name' => 'invite agent']);

        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'Administrator']);
        $adminRole->givePermissionTo('view all tickets');
        $adminRole->givePermissionTo('create ticket');
        $adminRole->givePermissionTo('edit ticket');
        $adminRole->givePermissionTo('delete ticket');
        $adminRole->givePermissionTo('assign ticket');
        $adminRole->givePermissionTo('invite agent');

        $agentRole = Role::create(['name' => 'Agent']);
        $agentRole->givePermissionTo('view all tickets');
        $agentRole->givePermissionTo('create ticket');
        $agentRole->givePermissionTo('edit ticket');

        $customerRole = Role::create(['name' => 'Customer']);
        $customerRole->givePermissionTo('create ticket');
        $customerRole->givePermissionTo('view my tickets');

        //Create users
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Password123')
        ]);
        $adminUser->assignRole('Administrator');

        $agentUser = User::factory()->create([
            'name' => 'Agent',
            'email' => 'agent@agent.com',
            'password' => bcrypt('Password123')
        ]);
        $agentUser->assignRole('Agent');

        $acustomerUser = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@customer.com',
            'password' => bcrypt('Password123')
        ]);
        $acustomerUser->assignRole('Customer');
    }
}
