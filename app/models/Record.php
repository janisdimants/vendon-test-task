<?php

namespace App\Models;

use App\Core\App;
use Exception;

class Record
{
    protected static $table; //e.g. 'users'

    protected static $recordable; //e.g. ['name', 'age']

    /**
     * Statically creates a record in the database from the given data
     * and returns instance of the model
     *
     * @param $data
     * @return mixed
     */
    public static function create($data)
    {
        $class_name = get_called_class();
        $record_id = App::get('database')->insert($class_name::$table, self::filter($data));
        $record = array_merge([
            'id' => $record_id
        ], $data);
        return $class_name::instantiate($record);
    }

    /**
     * Creates new record for the model in the database, if model does not have an id
     * or updates existing record if model has an id
     *
     * @return bool
     */

    public function save()
    {
        $class_name = get_called_class();
        if (!isset($this->id)) {
            //create new record
            $this->id = App::get('database')->insert($class_name::$table, $this->getRecordableData());
        } else {
            //update existing record
            App::get('database')->update($class_name::$table, $this->id, $this->getRecordableData());
        }

        return true;
    }

    //delete
    public function delete()
    {

    }

    /**
     * Filters data that can be recorded on the model from a given dataset
     *
     * @param $data
     * @return array
     */
    public static function filter($data)
    {
        $class_name = get_called_class();
        return array_filter((array)$data, function ($key) use ($class_name) {
            return in_array($key, $class_name::$recordable);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Gets an array of data off the model that can be recorded in the database
     *
     * @return array
     */
    public function getRecordableData()
    {
        $class_name = get_called_class();
        $recordable_data = [];
        foreach($class_name::$recordable as $key) {
            $recordable_data[$key] = $this->{$key};
        };
        return $recordable_data;
    }

    /**
     * Instantiates model from the given data
     *
     * @param $data
     * @return mixed
     */
    public static function instantiate($data)
    {
        $data = (object)$data;
        $class_name = get_called_class();
        $recordable_data = self::filter($data);
        $model = new $class_name();
        $model->id = $data->id;
        foreach($recordable_data as $key => $value){
            $model->$key = $value;
        }
        return $model;
    }

    /**
     * Returns a list of models from records of a given table
     * @return array
     */
    static public function all()
    {
        $class_name = get_called_class();
        $records = App::get('database')->selectAll($class_name::$table);

        $collection = [];

        foreach ($records as $record) {
            $collection[] = $class_name::instantiate($record);
        }


        return $collection;
    }

    /**
     * Finds record in the given table by id
     *
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        $class_name = get_called_class();
        $record = App::get('database')->selectOne($class_name::$table, $id);
        if ($record) {
            return self::instantiate($record);
        } else {
            throw new Exception("$class_name with this ID not found");
        }
    }


}