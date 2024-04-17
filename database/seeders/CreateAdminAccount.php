<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->login = 'Admin';
        $user->email = 'admin@admin.com';
        $user->name = 'Admin';
        $user->last_name = 'Root';
        $user->password = Hash::make('admin');
        $user->save();

        if (!$user->id) {
            $this->command->error("Cannot create admin account!");
        }
    }
}
