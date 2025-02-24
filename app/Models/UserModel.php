<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    public function getUserByPhone($phone)
    {
        return $this->where('phone', $phone)->first();
    }
}