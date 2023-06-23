<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{
    #[Route('/users/{id}/orders', name: 'user_orders', methods: ['GET'])]
    public function getUserOrders(OrdersRepository $ordersRepository, int $id): Response
    {
        $userOrders = $ordersRepository->findBy(['user' => $id]);
        return $this->json($userOrders);
    }
}
