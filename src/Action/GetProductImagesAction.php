<?php

namespace App\Action;

use App\Entity\ProductImages;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;

class GetProductImagesAction
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Products $product)
    {
       
        $images = $this->entityManager->getRepository(ProductImages::class)->findBy(['product' => $product]);

    
        return $images;
    }
}
