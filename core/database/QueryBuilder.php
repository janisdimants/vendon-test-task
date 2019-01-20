<?php

namespace App\Core\Database;

use PDO;

class QueryBuilder
{
    /**
     * The PDO instance.
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * Create a new QueryBuilder instance.
     *
     * @param PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Select all records from a database table.
     *
     * @param string $table
     */
    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Select record by id from database table
     *
     *
     */

    public function selectOne($table, $id)
    {
        $statement = $this->pdo->prepare("select * from {$table} where id = {$id}");

        $statement->execute();

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Select all records from a database table where fields match the value.
     * 
     * @param string $table
     * @param string $related_field
     * @param string $related_value
     */
    public function selectByRelatedValue($table, $related_field, $related_value)
    {
        $sql = sprintf(
            'select * from %s where %s=%s',
            $table,
            $related_field,
            $related_value
        );

        $statement = $this->pdo->prepare($sql);
    
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectWhere($table, $parameters)
    {
        $parameter_string = implode(' and ', array_map(
            function ($value, $key) { return sprintf("%s=%s", $key, $value); },
            $parameters,
            array_keys($parameters)
        ));
        

        $sql = sprintf(
            'select * from %s where %s',
            $table,
            $parameter_string
        );
        $statement = $this->pdo->prepare($sql);
    
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Insert a record into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        $statement = $this->pdo->prepare($sql);

        $statement->execute($parameters);

        return $this->pdo->lastInsertId();
    }

    /**
     * Updates a record in the database by id
     *
     * @param $table
     * @param $id
     * @param $parameters
     * @return bool
     */
    public function update($table, $id, $parameters)
    {
        $parameter_string = implode(', ', array_map(
            function ($value, $key) { return sprintf("%s=%s", $key, $value); },
            $parameters,
            array_keys($parameters)
        ));
        
        $sql = sprintf(
            'update %s SET %s where id=%s',
            $table,
            $parameter_string,
            $id
        );

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return true;
    }

    public function delete($table, $id)
    {
        $sql = sprintf(
            'delete from %s where id = %s',
            $table,
            $id
        );

        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute();

            return true;

        } catch (\Exception $e) {
            //
        }
    }
}
