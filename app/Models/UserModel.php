<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'password_hash', 'is_admin'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'name'  => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email]|max_length[150]',
        'phone' => 'permit_empty|max_length[25]',
    ];
}
