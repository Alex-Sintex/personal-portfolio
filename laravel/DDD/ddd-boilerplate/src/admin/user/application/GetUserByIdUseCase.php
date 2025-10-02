<?php

namespace Src\admin\user\application;

use App\Models\User;
use Src\admin\user\domain\contracts\UserRepositoryInterface;

class GetUserByIdUseCase
{
    private UserRepositoryInterface $userRepository;

    public function ___construct(UserRepositoryInterface $userInterface)
    {
        $this->$userInterface = $userInterface;
    }

    public function ___invoke(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}