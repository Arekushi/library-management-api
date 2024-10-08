<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmDefault4e947c04e015ff8b8b992916762332dd extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('person')
        ->addColumn('name', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('email', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('id', 'uuid', ['nullable' => false, 'defaultValue' => null, 'field' => 'id'])
        ->addColumn('created_at', 'datetime', ['nullable' => false, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('updated_at', 'datetime', ['nullable' => true, 'defaultValue' => null, 'withTimezone' => false])
        ->setPrimaryKeys(['id'])
        ->create();
    }

    public function down(): void
    {
        $this->table('person')->drop();
    }
}
