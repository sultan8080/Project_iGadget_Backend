<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{
    #[Route('/api/users/{id}/orders', name: 'user_orders', methods: ['GET'])]
    public function getUserOrders(OrdersRepository $ordersRepository, int $id): Response
    {
        $usersOrders = $ordersRepository->findBy(['users' => $id]);
        return $this->json($usersOrders);
    }
}
