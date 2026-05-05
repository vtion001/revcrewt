<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWaitlist extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'email' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'ENUM', 'constraint' => ['jobseeker', 'employer', 'both'], 'default' => 'jobseeker'],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'invited', 'converted'], 'default' => 'pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('waitlist');
    }

    public function down()
    {
        $this->forge->dropTable('waitlist');
    }
}
