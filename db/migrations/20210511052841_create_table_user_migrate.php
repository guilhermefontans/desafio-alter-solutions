<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableUserMigrate extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('usuario');
        $table->addColumn('nome', 'string', ['limit' => 35])
            ->addColumn('sobrenome', 'string', ['limit' => 35])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('idade', 'integer', ['limit' => 3])
            ->addColumn('senha', 'string', ['limit' => 255])
            ->create();
    }
}
