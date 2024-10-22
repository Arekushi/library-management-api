<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmDefaultF0a460f452da2661818456e449a56b9b extends Migration
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
        ->addIndex(['person_uuid'], ['name' => 'telephone_index_person_uuid_67052de082ed3', 'unique' => false])
        ->addForeignKey(['person_uuid'], 'person', ['uuid'], [
            'name' => 'telephone_foreign_person_uuid_67052de086a0b',
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
        $this->table('loan')
        ->addColumn('loan_start_date', 'datetime', ['nullable' => false, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('loan_end_date', 'datetime', ['nullable' => false, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('returned_date', 'datetime', ['nullable' => true, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('uuid', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('created_at', 'datetime', ['nullable' => false, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('updated_at', 'datetime', ['nullable' => true, 'defaultValue' => null, 'withTimezone' => false])
        ->addColumn('person_uuid', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addColumn('book_uuid', 'string', ['nullable' => false, 'defaultValue' => null, 'size' => 255])
        ->addIndex(['person_uuid'], ['name' => 'loan_index_person_uuid_67052de089884', 'unique' => false])
        ->addIndex(['book_uuid'], ['name' => 'loan_index_book_uuid_67052de0898cb', 'unique' => false])
        ->addForeignKey(['person_uuid'], 'person', ['uuid'], [
            'name' => 'loan_foreign_person_uuid_67052de089895',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->addForeignKey(['book_uuid'], 'book', ['uuid'], [
            'name' => 'loan_foreign_book_uuid_67052de0898d5',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
            'indexCreate' => true,
        ])
        ->setPrimaryKeys(['uuid'])
        ->create();
    }

    public function down(): void
    {
        $this->table('loan')->drop();
        $this->table('book')->drop();
        $this->table('telephone')->drop();
        $this->table('person')->drop();
    }
}
