<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductImagesController extends AbstractController
{
    #[Route('/api/products/{id}/productimages', name: 'get_product_images', methods: ["GET"])]
    public function getProductImages(Products $product): JsonResponse
    {
        $images = $product->getProductImages();

        if (count($images) === 0) {
            return $this->json([]);
        }

        return $this->json($images);
    }
}

