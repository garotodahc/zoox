<?php


namespace App\Action;

use App\Domain\City\Repository\CityCreatorRepository;
use App\Domain\City\Service\CityCreator;
use MongoDB\Driver\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class CityCreateAction
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
        // Collecting input from the HTTP request
        $data = (array)$request->getParsedBody();

        $state = $this->cityCreator->createCity($data);

        // Transform the result into the JSON representation
        $result = [
            'rows_affected' => $state
        ];


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
