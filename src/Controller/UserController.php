<?php

namespace App\Controller;

use App\Domain\User\User;
use App\Domain\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users')]
class UserController extends AbstractController
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/fetch', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        $users = $this->userRepository->fetchAll(); 
        $this->userRepository->saveMultiple($users);
        return $this->json($users);
    }


}