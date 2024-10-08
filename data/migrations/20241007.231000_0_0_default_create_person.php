<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmDefaultF65ad6e742006ff9b4f1094c7ab82c41 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('person')
        ->addColumn('name', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('email', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('uuid', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('created_at', 'datetime', ['nullable' => false, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('updated_at', 'datetime', ['nullable' => true, 'defaultValue' => null, 'withTimezone' => false])
        ->setPrimaryKeys(['uuid'])
        ->create();
    }

    public function down(): void
    {
        $this->table('person')->drop();
    }
}
