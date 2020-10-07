<?php
namespace App\Domain\State\Service;

use App\Domain\State\Repository\StateCreatorRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class StateCreator
{
    /**
     * @var StateCreatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param StateCreatorRepository $repository The repository
     */
    public function __construct(StateCreatorRepository $repository)
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
    public function createState(array $data): int
    {
        // Input validation
        $this->validateNewUser($data);

        // Insert user
        $userId = $this->repository->insertState($data);

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $userId;
    }

    /**
     * List  states.

     *
     * @return arrays The new user ID
     */
    public function ListStates(): array
    {
        $states = $this->repository->listStates();

        return $states;
    }


    /**
     * Update state.
     * @return arrays The new user ID
     */
    public function UpdateState(array $data, $idparameter): array
    {
        // Input validation
        $this->validateNewUser($data);

        $state = $this->repository->updateState($data, $idparameter);

        return $state;
    }


    /**
     * Delete state.
     * @return arrays The new user ID
     */
    public function DeleteStates($id): array
    {
        $state = $this->repository->deleteStateById($id);

        return $state;
    }


    /**
     * Delete state.
     * @return arrays The new user ID
     */
    public function SearchStateByid($id):array
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

        if (empty($data['abbreviation']))
        {
            $errors['abbreviation'] = 'Abbreviation input required';
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
