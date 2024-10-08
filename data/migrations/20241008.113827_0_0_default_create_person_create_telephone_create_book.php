<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmDefault25719b110b5af6cad0da15a0605c96df extends Migration
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
        $this->table('telephone')
        ->addColumn('number', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('uuid', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('created_at', 'datetime', ['nullable' => false, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('updated_at', 'datetime', ['nullable' => true, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('person_uuid', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addIndex(['person_uuid'], ['name' => 'telephone_index_person_uuid_670519b3802e7', 'unique' => false])
        ->addForeignKey(['person_uuid'], 'person', ['uuid'], [
            'name' => 'telephone_foreign_person_uuid_670519b3803c3',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->setPrimaryKeys(['uuid'])
        ->create();
        $this->table('book')
        ->addColumn('title', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('isbn', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('description', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('publisher', 'string', ['nullable' => false, 'defaultValue' => null, 'length' => 255, 'size' => 255])
        ->addColumn('copies', 'integer', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('publication_year', 'integer', ['nullable' => false, 'defaultValue' => null])
        ->addColumn('uuid', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('created_at', 'datetime', ['nullable' => false, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('updated_at', 'datetime', ['nullable' => true, 'defaultValue' => null, 'withTimezone' => false])
        ->setPrimaryKeys(['uuid'])
        ->create();
    }

    public function down(): void
    {
        $this->table('book')->drop();
        $this->table('telephone')->drop();
        $this->table('person')->drop();
    }
}
