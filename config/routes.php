<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {

    /**
     * @OA\Info(title="My API ZOOX WITH SLIM 4.*", version="0.1")
     */

    /**
     * @OA\Get(
     *     path="/api/resource.json",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    /*States end-points*/
    $app->post('/states', \App\Action\StateCreationAction::class);

    $app->get('/states/list', \App\Action\StateListAction::class);

    $app->put('/states/update/{id}', \App\Action\StateUpdateAction::class);

    $app->delete('/states/delete/{id}', \App\Action\DeleteStateAction::class);

    /*Citys end-points*/
    $app->post('/city', \App\Action\CityCreateAction::class);

    $app->get('/city/list', \App\Action\CitiesListAction::class);

    $app->put('/city/update/{id}', \App\Action\CityUpdateAction::class);

    $app->delete('/city/delete/{id}', \App\Action\DeleteCityAction::class);
};
