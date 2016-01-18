<?php 

namespace Kirkbater\Testing;

/**
 * Soft Deletes Trait for Laravel 5.1.  This code was packaged by Kirk Bater, but was originally written
 * on this Stack Overflow question: http://stackoverflow.com/questions/33117746/laravel-unit-testing-how-to-seeindatabase-soft-deleted-row.
 */
trait SoftDeletes {
    
    /**
     * Assert that a given where condition does not matches a soft deleted record
     *
     * @param  string $table
     * @param  array  $data
     * @param  string $connection
     * @return $this
     */
    protected function seeIsNotSoftDeletedInDatabase($table, array $data, $connection = null)
    {
        $database = $this->app->make('db');
        $connection = $connection ?: $database->getDefaultConnection();
        $count = $database->connection($connection)
            ->table($table)
            ->where($data)
            ->whereNull('deleted_at')
            ->count();
        $this->assertGreaterThan(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].', $table, json_encode($data)
        ));
        return $this;
    }

    /**
     * Assert that a given where condition matches a soft deleted record
     *
     * @param  string $table
     * @param  array  $data
     * @param  string $connection
     * @return $this
     */
    protected function seeIsSoftDeletedInDatabase($table, array $data, $connection = null)
    {
        $database = $this->app->make('db');
        $connection = $connection ?: $database->getDefaultConnection();
        $count = $database->connection($connection)
            ->table($table)
            ->where($data)
            ->whereNotNull('deleted_at')
            ->count();
        $this->assertGreaterThan(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].', $table, json_encode($data)
        ));
        return $this;
    }
}