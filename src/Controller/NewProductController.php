<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class NewProductController extends AbstractController
{
    #[Route(path: '/new-products', name: 'new_products', methods: ["GET"])]
    public function getNewProducts(ManagerRegistry $managerRegistry): JsonResponse
    {
        $repository = $managerRegistry->getRepository(Product::class);
        $newProducts = $repository->findBy([], ['createdAt' => 'DESC'], 3);


        $formattedProducts = [];

        return new JsonResponse($formattedProducts);
    }
}
