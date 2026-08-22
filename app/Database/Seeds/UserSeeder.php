<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'          => 'Admin Jacquelle',
                'email'         => 'admin@jacquelle.com',
                'phone'         => '081234567890',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'is_admin'      => 1,
            ],
            [
                'name'          => 'Rara Cantik',
                'email'         => 'rara@example.com',
                'phone'         => '085612345678',
                'password_hash' => password_hash('rara123', PASSWORD_DEFAULT),
                'is_admin'      => 0,
            ],
        ];

        foreach ($users as $user) {
            $user['created_at'] = date('Y-m-d H:i:s');
            $user['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('users')->insert($user);
        }

        echo "Seeded " . count($users) . " users.\n";
        echo "Login demo: admin@jacquelle.com / admin123\n";
    }
}
