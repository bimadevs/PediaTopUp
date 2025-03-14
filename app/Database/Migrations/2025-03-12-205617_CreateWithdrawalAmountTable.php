<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWithdrawalAmountTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'amount' => [
                'type' => 'DOUBLE',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['0', '1'],
                'default' => '1',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('withdrawal_amount');
        
        // Tambahkan beberapa nominal default
        $data = [
            [
                'amount' => 50000,
                'status' => '1',
            ],
            [
                'amount' => 100000,
                'status' => '1',
            ],
            [
                'amount' => 200000,
                'status' => '1',
            ],
            [
                'amount' => 500000,
                'status' => '1',
            ],
            [
                'amount' => 1000000,
                'status' => '1',
            ],
        ];
        
        $this->db->table('withdrawal_amount')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('withdrawal_amount');
    }
}
