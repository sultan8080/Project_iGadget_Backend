<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/products/latest', name: 'latest_products', methods: ['GET'])]
    public function latestProducts(): JsonResponse
    {
        $latestProducts = $this->em->getRepository(Products::class)->findBy([], ['createdAt' => 'DESC'], 3);

        return $this->json($latestProducts);
    }
}
