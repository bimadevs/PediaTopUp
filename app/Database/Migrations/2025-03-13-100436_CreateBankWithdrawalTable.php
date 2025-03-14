<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBankWithdrawalTable extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => 'bank.jpg',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['On', 'Off'],
                'default' => 'On',
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
        $this->forge->createTable('bank_withdrawal');
        
        // Tambahkan beberapa bank default
        $data = [
            [
                'name' => 'Bank BCA',
                'code' => 'BCA',
                'icon' => 'bca.jpg',
                'status' => 'On',
            ],
            [
                'name' => 'Bank Mandiri',
                'code' => 'MANDIRI',
                'icon' => 'mandiri.jpg',
                'status' => 'On',
            ],
            [
                'name' => 'Bank BNI',
                'code' => 'BNI',
                'icon' => 'bni.jpg',
                'status' => 'On',
            ],
        ];
        
        $this->db->table('bank_withdrawal')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('bank_withdrawal');
    }
}
