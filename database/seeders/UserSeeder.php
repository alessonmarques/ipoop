<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@ipoop.com',
            'password' => Hash::make('admin123'),
            'type' => 'admin'
        ]);

        User::create([
            'name' => 'Usuário Padrão',
            'email' => 'usuario@ipoop.com',
            'password' => Hash::make('usuario123'),
            'type' => 'user'
        ]);
    }
}