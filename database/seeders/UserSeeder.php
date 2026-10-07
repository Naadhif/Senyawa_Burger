<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed akun default: kasir & owner.
     * Password: kasir123 (kasir) | owner123 (owner)
     */
    public function run(): void
    {
        DB::table('user')->upsert([
            [
                'nama'     => 'Owner Senyawa',
                'username' => 'owner',
                'password' => password_hash('owner123', PASSWORD_BCRYPT),
                'role'     => 'owner',
            ],
            [
                'nama'     => 'Kasir Senyawa',
                'username' => 'kasir',
                'password' => password_hash('kasir123', PASSWORD_BCRYPT),
                'role'     => 'kasir',
            ],
        ], ['username'], ['nama', 'password', 'role']);
    }
}
