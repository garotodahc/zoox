<?php


namespace App\Action;


use App\Domain\State\Repository\StateCreatorRepository;
use App\Domain\State\Service\StateCreator;
use MongoDB\Driver\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteStateAction
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

        $id_Parameter =  $request->getAttribute('id');

        $state = $this->stateCreator->DeleteStates($id_Parameter);

        // Transform the result into the JSON representation
        $result = [
            'deleted_state' => $state
        ];


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
