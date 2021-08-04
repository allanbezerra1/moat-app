<?php

namespace App\Services;

use App\Repository\UserRepositoryInterface;

class UserServices
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function All()
    {
        return $this->userRepository->All();
    }

    public function FindById(int $id)
    {
        return $this->userRepository->findById($id);
    }
    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $this->userRepository->update($id, $data);
        return response()->json(['message' => 'User Updated'], 200);
    }

    public function destroy(int $id)
    {
        $this->userRepository->deleteById($id);
        return response()->json(['message' => 'User Deleted'], 200);
    }
}