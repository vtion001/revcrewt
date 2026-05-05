<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInteractionRequests extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'employer_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'talent_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'type' => ['type' => 'ENUM', 'constraint' => ['free_interview', 'paid_interview', 'paid_assessment'], 'default' => 'free_interview'],
            'subject' => ['type' => 'VARCHAR', 'constraint' => 255],
            'message' => ['type' => 'TEXT', 'null' => true],
            'proposed_salary' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'accepted', 'declined', 'completed', 'cancelled'], 'default' => 'pending'],
            'amount_paid' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'service_fee' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'responded_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('employer_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('talent_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('interaction_requests');
    }

    public function down()
    {
        $this->forge->dropTable('interaction_requests');
    }
}
