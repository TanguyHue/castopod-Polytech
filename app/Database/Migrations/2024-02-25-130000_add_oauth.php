<?php

declare(strict_types=1);

/**
 * Class AddOAuthTable creates oauth table in database
 *
 * @copyright  2024 Polytech Nantes
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace App\Database\Migrations;

class AddOAuthTable extends BaseMigration
{
    public function up(): void
    {
        $fields = [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'idUser' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'lastRefreshToken' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('email', true);
        $this->forge->addForeignKey('idUser', 'users', 'id');
        $this->forge->createTable('oauth');
    }

    public function down(): void
    {
        $this->forge->dropTable('oauth');
    }
}
