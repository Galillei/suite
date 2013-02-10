<?php
namespace Library;

/**
 * Base model class.
 */
abstract class Model
{
    /**
     * MySQL datetime format.
     */
    const MYSQL_DATETIME_FORMAT = 'Y:m:d h:i:s';

    /**
     * Object properties to db columns mapping.
     *
     * @var array
     */
    protected static $mapping = array();

    /**
     * Gets db column name by object property name.
     *
     * @static
     * @param string $property Object property name.
     * @return string|null
     */
    private static function findColumnByProperty($property)
    {
        return (isset(static::$mapping[$property]) ? static::$mapping[$property] : null);
    }

    /**
     * Gets object property name by db column name.
     *
     * @static
     * @param string $column DB column name.
     * @return null
     */
    private static function findPropertyByColumn($column)
    {
        if (($flipped = array_flip(static::$mapping)) && isset($flipped[$column]))
        {
//            echo'Flipped array';
//            var_dump(static::$mapping);
//            echo '$flipped:';
//           die(var_dump($flipped[$column]));
            return $flipped[$column];
        }

        return null;
    }

    /**
     * Transforms db rowset into array of model objects.
     *
     * @static
     * @param array $rawData DB rowset.
     * @return array
     */
    protected static function fillFromDB($rawData)
    {
//        die(var_dump($rawData));
        $objects = array();
        foreach ($rawData as $row)
        {
//            die(var_dump($row));

            $model = self::createInstanceFromDBRow($row);

            $objects[]= $model;

        }

        return $objects;
    }

    /**
     * Creates model object instance from db row.
     *
     * @static
     * @param array $row DB row.
     * @return Model
     */
    protected static function createInstanceFromDBRow($row)//массив получает а возвращает в объекты
    {
        $instance = new static();
//        echo '$row:';

        foreach ($row as $column => $value)
        {
//            echo '$instance:';
//            var_dump($instance);
//            echo '$column:';
//            var_dump($column);
//            echo '$value:';
//         die(var_dump($value));
            self::setPropertyFromColumn($instance, $column, $value);
        }

        return $instance;
    }

    /**
     * Sets object property value.
     *
     * @static
     * @param Model $instance Object.
     * @param string $column DB column
     * @param $value Value to set.
     */
    private static function setPropertyFromColumn($instance, $column, $value)
    {
        if ($propertyName = self::findPropertyByColumn($column))
        {
            $reflectionObject = new \ReflectionObject($instance);

            $reflectionProperty = $reflectionObject->getProperty($propertyName);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($instance, $value);

        }
    }

    /**
     * Gets object unique id.
     *
     * @abstract
     * @return mixed
     */
    public abstract function getId();

    /**
     * Gets DB connection.
     *
     * @static
     * @return \PDO
     */
    public static function getDBConnection()
    {
        return \FrontController::getInstance()->getDbConnection();// создаёт frontci\ontroller и вызывает метод getDbConnection()
    }

    /**
     * Saves object instance into db.
     */
    public function save()
    {
        if ($this->getId())
            $this->saveUpdate();
        else
            $this->saveInsert();
    }

    /**
     * Object update.
     *
     * @abstract
     * @return mixed
     */
    protected abstract function saveUpdate();

    /**
     * New object creation.
     *
     * @abstract
     * @return mixed
     */
    protected abstract function saveInsert();
    /**
     * Object update.
     *
     * @abstract
     * @return mixed
     */
    protected  abstract function delete();


}