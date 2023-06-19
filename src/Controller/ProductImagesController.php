<?php

namespace App\Controller;

use App\Entity\ProductImages;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductImagesController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/api/products/{id}/productimages', name: 'get_product_images', methods: ["GET"])]
    public function getProductImages(Products $product): JsonResponse
    {
        $images = $product->getProductImages();
        // // return $this->json($images);
        return $this->json("yo");
    }
}

