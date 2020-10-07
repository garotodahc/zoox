<?php


namespace App\Action;

use App\Domain\City\Repository\CityCreatorRepository;
use App\Domain\City\Service\CityCreator;
use MongoDB\Driver\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CityUpdateAction
{

    /**
     *CityCreationAction constructor.
     * @param $cityCreator
     */
    public function __construct()
    {
        $repository = new CityCreatorRepository(Manager::class);
        $this->cityCreator = new CityCreator($repository);
    }

    public function __invoke( ServerRequestInterface $request,
                              ResponseInterface $response
    ): ResponseInterface
    {
        $id_Parameter =  $request->getAttribute('id');
        $data = (array)$request->getParsedBody();

        $cities = $this->cityCreator->UpdateCity($data, $id_Parameter);

        // Transform the result into the JSON representation
        $result = [
            'city' => $cities
        ];


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
