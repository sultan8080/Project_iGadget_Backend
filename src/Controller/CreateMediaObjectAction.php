<?php

namespace App\Controller;

use App\Entity\ProductImages;
use App\Entity\Products;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateMediaObjectAction extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request): ProductImages
    {
        $uploadedFile = $request->files->get('post_thumbnail');
        
        $product = $this->em->getRepository(Products::class)->find(2);
        // dd($product);


        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new ProductImages();
        $mediaObject->setImageFile($uploadedFile);
        $mediaObject->setImageName('gchg');
        $mediaObject->setProducts($product);

        // dd($mediaObject);

        return $mediaObject;
    }
}