<?php
namespace App\Domain\City\Repository;

use MongoDB;

class CityCreatorRepository
{
    /**
     * @var \MongoDB The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param Mongo $connection The database connection
     */
    public function __construct()
    {


        $options = [
            'password' => '123456' ,
            'username' => 'admin',
        ];


        try {

            $this->connection = new  MongoDB\Driver\Manager("mongodb://localhost:27017", $options);
            //  ^^^^^ make a class property
        }
        catch (MongoDB\Driver\Exception\Exception $e) {

            echo $e->getMessage(), "\n";
        }
    }

    /**
     * Insert State row.
     *
     * @param array $state The user
     *
     * @return int The new ID
     */

    public function insertCity(array $state): int
    {

        $bulk = new MongoDB\Driver\BulkWrite;
        $doc = ['_id' => new MongoDB\BSON\ObjectID, 'id' => $state['id'],  'name' => $state['name'],  'estadoId' => $state['estadoId'], 'create_at' => $state['create_at'], 'update_at' => $state['update_at']];
        $bulk->insert($doc);
        $result = $this->connection->executeBulkWrite('zoox.cidades', $bulk);

        return (int) $result->nInserted;
    }


    /**
     * List States rows.
     * @return array of States
     */

    public function listCities(): array
    {


        $query = new MongoDB\Driver\Query([]);
        $rows =  $this->connection->executeQuery("zoox.cidades", $query);
        $result = array();
        foreach ($rows as $item) {

            array_push($result, $item);
        }
        return (array) $result ;
    }


    /**
     * Update State.
     *
     * @return array of States
     */

    public function updateCity(array $state, $idparameter)
    {

        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->update  (['id' => $idparameter], ["name" => $state['name'],
            "abbreviation" => $state['abbreviation'],
            "create_at" => $state['create_at'],
            "update_at" => $state['update_at'],
            "id" => $state['id']]);

        $resul = $this->connection->executeBulkWrite('zoox.cidades', $bulk);

        return (array)$resul;
    }

    /**
     * Delete State.
     *
     * @return state deleted
     */

    public function deleteCityById($id)
    {
        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->delete(['id' => $id]);

        $resul = $this->connection->executeBulkWrite('zoox.cidades', $bulk);

        return (array)$resul;
    }


    public function searchById($id)
    {
        $filter = [ 'id' =>  $id ];
        $query = new MongoDB\Driver\Query($filter);

        $res = $this->connection->executeQuery("zoox.cidades", $query);

        $state = current($res->toArray());

        return (array)$state;
    }
}
