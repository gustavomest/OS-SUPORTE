<?php

namespace Database\Seeders;

use App\Models\User; // Importar o model User
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Importar o Hash para a senha

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria o usuário administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Altere para uma senha segura
            'is_admin' => true,
        ]);
    }
}