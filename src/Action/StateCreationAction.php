<?php


namespace App\Action;

use App\Domain\State\Repository\StateCreatorRepository;
use App\Domain\State\Service\StateCreator;
use MongoDB\Driver\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class StateCreationAction
{


    /**
     * StateCreationAction constructor.
     * @param $stateCreator
     */
    public function __construct()
    {
        $repository = new StateCreatorRepository(Manager::class);
        $this->stateCreator = new StateCreator($repository);
    }

    public function __invoke( ServerRequestInterface $request,
                              ResponseInterface $response
    ): ResponseInterface
    {
        // Collecting input from the HTTP request
        $data = (array)$request->getParsedBody();

        $state = $this->stateCreator->createState($data);

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
