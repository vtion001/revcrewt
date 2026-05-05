<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrackedTalents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'employer_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'talent_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['employer_id', 'talent_id']);
        $this->forge->addForeignKey('employer_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('talent_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tracked_talents');
    }

    public function down()
    {
        $this->forge->dropTable('tracked_talents');
    }
}
