<?php
namespace  App\Domain\City\Service;

use App\Domain\City\Repository\CityCreatorRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class CityCreator
{
    /**
     * @var CityCreatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param CityCreatorRepository $repository The repository
     */
    public function __construct(CityCreatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new state.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function createCity(array $data): int
    {
        // Input validation
        $this->validateNewUser($data);

        // Insert user
        $cityId = $this->repository->insertCity($data);

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $cityId;
    }

    /**
     * List  states.

     *
     * @return arrays The new user ID
     */
    public function ListCities(): array
    {
        $cities = $this->repository->listCities();

        return $cities;
    }


    /**
     * Update state.
     * @return arrays The new user ID
     */
    public function UpdateCity(array $city, $idparameter): array
    {
        // Input validation
        $this->validateNewUser($city);

        $city = $this->repository->updateCity($city, $idparameter);

        return $city;
    }


    /**
     * Delete state.
     * @return arrays The new user ID
     */
    public function DeleteCity($id): array
    {
        $state = $this->repository->deleteCityById($id);

        return $state;
    }


    /**
     * Delete state.
     * @return arrays The new user ID
     */
    public function SearchCityByid($id):array
    {
        $state = $this->repository->searchById($id);

        return $state;
    }



    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewUser(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library
        if (empty($data['id'])) {
            $errors['id'] = 'id innput required';
        }

        if (empty($data['name'])) {
            $errors['name'] = 'Name innput required';
        }

        if (empty($data['estadoId']))
        {
            $errors['estadoId'] = 'estadoId input required';
        }

        if (empty($data['create_at']))
        {
            $errors['create_at'] = 'create_at input required';
        }

        if (empty($data['update_at']))
        {
            $errors['update_at'] = 'update_at input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
