<?php

namespace App\Controller;

use App\Entity\ProductImages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateMediaObjectAction extends AbstractController
{
    public function __invoke(Request $request): ProductImages
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }
        
        $mediaObject = new ProductImages();
        $mediaObject->setImageFile($uploadedFile);
        $mediaObject->setImageName('gchg');
        // dd($mediaObject);

        return $mediaObject;
    }
}