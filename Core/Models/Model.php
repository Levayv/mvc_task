<?php

namespace Core\Models;

use Core;
use Core\Exceptions\ModelException;
use PDO;
use PDOStatement;
use ReflectionClass;

class Model
{
    public string $tableName;

    public function __construct()
    {
        // todo research which solution is better
        //$className = (new ReflectionClass($this))->getShortName();
        $fqn = self::getCallerClassName();
        $fqnArray = explode('\\' , $fqn);
        $className = array_pop($fqnArray);
        $fqnArray = null;
        $this->tableName = mb_strtolower($className) . 's';
    }

    // todo accessor mutator using __get __set

    private function getNewModel()
    {
        $childModelClassName = self::getCallerClassName();
        return new $childModelClassName;
    }

    public static function getCallerClassName()
    {
        // this >> object
        // self >> current class , function get_class() or self::class
        // static >> caller class , function get_called_class() or static::class
        return static::class;
    }

    /**
     * Get list of all models
     * @return array
     * @throws ModelException
     */
    public static function getList()
    {
        $db = new DBHelper(self::getNewModel());
        $result = $db->selectAll();
        $collection = [];
        foreach ($result as $item){
            $model = self::writeToAttributes($item);
            array_push($collection , $model);
        }
        return $collection;
    }

    /**
     * Get single model by ID
     * @param int $id
     * @return Model
     * @throws ModelException
     */
    public static function getSingle(int $id)
    {
        if (!isset($id)) throw new ModelException('missing id - get single record');

        $db = new DBHelper(self::getNewModel());
        $result = $db->selectWhere($id);

        // todo temp
        if (count($result) == 1) {
            $result = $result[0];
        }

        return self::writeToAttributes($result);
    }

    private static function writeToAttributes($data)
    {
        $model = self::getNewModel();
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        // todo add excluded / included functionality for altering model properties
        // e.g. password hash , timestamps
        return $model;
    }
}
// todo move to another namespace
class DBHelper
{
    private DBConnection $connection;
    private PDOStatement $statement;
    private Model $model;
    private string $modelClassName;

    public function __construct(Model $model)
    {
        $this->connection = new DBConnection();
        $this->model = $model;
        $this->modelClassName = $model::getCallerClassName();
    }

    /**
     * Query SELECT * FROM $model->tableName
     * @return array
     * @throws ModelException
     */
    public function selectAll()
    {
        return $this->actualSelect($this->model->tableName, null);
    }

    /**
     * Query SELECT * FROM $model->tableName WHERE ( ID = $id )
     * @param int $id
     * @return array
     * @throws ModelException
     */
    public function selectWhere(int $id)
    {
        return $this->actualSelect($this->model->tableName, $id);
    }

    /**
     * Creates SQL Query and passes to PDO execute
     * @param string $tableName
     * @param int|null $id
     * @return array
     * @throws ModelException
     */
    private function actualSelect(string $tableName, int $id = null)
    {
        $result = [];
        $query = 'SELECT * from ' . $tableName;
        if (isset($id)) {
            $query .= ' where ID = ' . $id;
        }

        $this->openConnection();
        $result = $this->execute($query);
        $this->closeConnection();
        return $result;
    }

    /**
     * @throws ModelException
     */
    private function openConnection()
    {
        $this->connection->open();
    }

    /**
     * CLose PDO handler and PDO statement
     * @param PDOStatement|null $statement
     */
    private function closeConnection(PDOStatement $statement = null)
    {
        if ($statement) $statement = null;
        $this->connection->close();
    }

    /**
     * Handles PDO execute method
     * @param string $query
     * @return array
     * @throws ModelException
     */
    public function execute(string $query)
    {
        if (!isset($query)) throw new ModelException('Query is empty');

        $statement = $this->connection->getHandle()->prepare($query);
        $success = $statement->execute();
        if (!$success) throw new ModelException('data not found in DB for Model = ' . $this->modelClassName);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $statement = null;
        // todo refactor for multiple statement handling

        return $result;
    }
}

class DBConnection
{
    private string $type = 'mysql';
    private string $host = 'localhost';
    private string $port = '3306'; //todo add to $dataSource
    private string $schema;
    private string $username;
    private string $password;
    private ?PDO $handle;

    public function __construct()
    {
        $this->schema = $_ENV['$DB_SCHEMA'];
        $this->username = $_ENV['$DB_USERNAME'];
        $this->password = $_ENV['$DB_PASSWORD'];
    }

    public function open()
    {
        $dataSource = ''
            . $this->type . ':'
            . 'host=' . $this->host . ';'
            . 'dbname=' . $this->schema . '';

        if (isset($this->handle)) throw new ModelException('DB connection was not closed when reopening new one');

        $this->handle = new PDO($dataSource, $this->username, $this->password);
    }

    public function close()
    {
        if (isset($this->handle)) {
            $this->handle = null;
        }
    }

    /**
     * @return PDO
     * @throws ModelException
     */
    public function getHandle()
    {
        if (!isset($this->handle)) throw new ModelException('DB connection wasn\'t open');
        return $this->handle;
    }

    // todo research do we need multiple connection ? singleton ? clone ?
//    public function cloneConnection()
//    {
//        $cloned = new DBConnection();
//        $cloned->type = $this->type;
//        $cloned->host = $this->host;
//        $cloned->port = $this->port;
//        $cloned->schema = $this->schema;
//        $cloned->username = $this->username;
//        $cloned->password = $this->password;
//        return $cloned;
//    }
//
//    public function getInstance(){
//        if (!isset($this->instance)){
//            $this->instance = new DBConnection();
//        }
//        return $this->instance;
//    }

}
