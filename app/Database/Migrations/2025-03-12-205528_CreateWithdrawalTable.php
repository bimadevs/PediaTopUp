<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWithdrawalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_bank' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'bank_account' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'account_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'total' => [
                'type' => 'DOUBLE',
            ],
            'fee' => [
                'type' => 'DOUBLE',
                'default' => 0,
            ],
            'note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'declined'],
                'default' => 'pending',
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
        $this->forge->createTable('withdrawal');
    }

    public function down()
    {
        $this->forge->dropTable('withdrawal');
    }
}
