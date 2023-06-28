<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/api/products_latest', name: 'latest_products', methods: ['GET'])]
    public function latestProducts(): JsonResponse
    {
        $latestProducts = $this->em->getRepository(Products::class)->findBy([], ['createdAt' => 'DESC'], 3);

        return $this->json($latestProducts);
    }
}
