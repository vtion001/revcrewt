<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTalentProfiles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'unique' => true],
            'headline' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'summary' => ['type' => 'TEXT', 'null' => true],
            'profile_photo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'location' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'skills' => ['type' => 'JSON', 'null' => true],
            'experience_years' => ['type' => 'INT', 'constraint' => 3, 'null' => true],
            'work_style' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'availability_status' => ['type' => 'ENUM', 'constraint' => ['open', 'exploring', 'receptive'], 'default' => 'exploring'],
            'salary_min' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'salary_max' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'profile_completion' => ['type' => 'INT', 'constraint' => 3, 'default' => 0],
            'is_premium' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'verified_badge' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('talent_profiles');
    }

    public function down()
    {
        $this->forge->dropTable('talent_profiles');
    }
}
