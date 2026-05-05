<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployerProfiles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'unique' => true],
            'org_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'org_logo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'org_website' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'org_size' => ['type' => 'ENUM', 'constraint' => ['1-10', '11-50', '51-200', '201-500', '500+'], 'null' => true],
            'industry' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'work_environment' => ['type' => 'ENUM', 'constraint' => ['remote', 'hybrid', 'onsite'], 'null' => true],
            'hiring_priorities' => ['type' => 'TEXT', 'null' => true],
            'engagement_prefs' => ['type' => 'JSON', 'null' => true],
            'is_premium' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'featured_status' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employer_profiles');
    }

    public function down()
    {
        $this->forge->dropTable('employer_profiles');
    }
}
