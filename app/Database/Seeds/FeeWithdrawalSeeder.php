<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FeeWithdrawalSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah pengaturan fee-withdrawal sudah ada
        $query = $this->db->table('utility')->where('u_key', 'fee-withdrawal')->get();
        
        if ($query->getNumRows() === 0) {
            // Jika belum ada, tambahkan dengan nilai default 2.5%
            $data = [
                'u_key' => 'fee-withdrawal',
                'u_value' => '2.5'
            ];
            
            $this->db->table('utility')->insert($data);
        }
    }
} 