<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Reply;
use App\Entity\Users;
use App\Entity\Orders;
use DateTimeImmutable;
use App\Entity\Reviews;
use App\Entity\Messages;
use App\Entity\Products;
use App\Entity\Categories;
use App\Entity\OrderStatus;
use App\Entity\ProductTags;
use App\Entity\OrderDetails;
use App\Entity\OrderReturns;
use App\Entity\ProductImages;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $listAdmin = [];
        for ($i = 1; $i < 2; $i++) {
            $admin = new Users();
            $admin->setFirstname($faker->firstName());
            $admin->setLastname($faker->lastName());
            $admin->setEmail('admin-' . $i . '@igadget.fr');
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setPassword($this->userPasswordHasher->hashPassword($admin, '123456'));
            $admin->setAddress($faker->streetAddress());
            $admin->setCodepostal($faker->postcode());
            $admin->setUserPhoto('Admin-Photo -' . $i . 'jpg');
            $admin->setPhone($faker->phoneNumber());
            $admin->setCity($faker->city());
            $admin->setIsVerified('1');
            $manager->persist($admin);
            $listAdmin[] = $admin;
        }

        $listUsers = [];
        for ($i = 1; $i < 2; $i++) {
            $user = new Users();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail('user-' . $i . '@igadget.fr');
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));
            $user->setAddress($faker->streetAddress());
            $user->setCodepostal($faker->postcode());
            $user->setUserPhoto('User-Photo -' . $i . 'jpg');
            $user->setPhone($faker->phoneNumber());
            $user->setCity($faker->city());
            $user->setIsVerified('1');
            $manager->persist($user);
            $listUsers[] = $user;
        }

        $categories = ['ordinatuer', 'portable', 'imprimante', 'montre', 'accessoires', 'électroménagers'];
        $listCategories = [];
        for ($i = 0; $i < count($categories); $i++) {
            $category = new Categories();
            $category->setName($categories[$i]);
            $manager->persist($category);
            $listCategories[] = $category;
        }
        $listProducts = [];

        for ($i = 0; $i < 10; $i++) {
            $product = new Products();
            $product->setReference($faker->sentence(3));
            $product->setName($faker->words(2, true));
            $product->setPrice($faker->randomFloat(2, 10, 200));
            $product->setDescription($faker->text(100));
            $product->setDimension($faker->numerify('dimension-####'));
            $product->setStock('true');
            $product->setUsers($listAdmin[array_rand($listAdmin)]);
            $product->setCategories($listCategories[array_rand($listCategories)]);
            $manager->persist($product);
            $listProducts[] = $product;
        }

        for ($i = 0; $i < 10; $i++) {
            $productTags = new ProductTags();
            $productTags->setLabel($faker->words(5, true));
            $productTags->addProduct($listProducts[array_rand($listProducts)]);
            $manager->persist($productTags);
        }

        for ($i = 1; $i < 15; $i++) {
            $productImages = new ProductImages();
            $productImages->setImageName('image-' . $i . 'jpg');
            $productImages->setProducts($listProducts[array_rand($listProducts)]);
            $manager->persist($productImages);
        }

        $orderStatusType = ['pending', 'approved'];
        $listOrderStatuType = [];
        for ($i = 0; $i < count($orderStatusType); $i++) {
            $orderStatus = new OrderStatus();
            $orderStatus->setTypeStatus($orderStatusType[$i]);
            $manager->persist($orderStatus);
            $listOrderStatuType[] = $orderStatus;
        }

        $listOrders = [];
        for ($i = 0; $i < 10; $i++) {
            $order = new Orders();
            $order->setOrderDate(new DateTimeImmutable());
            $order->setOrderStatus($listOrderStatuType[array_rand($listOrderStatuType)]);
            $order->setUsers($listUsers[array_rand($listUsers)]);
            $manager->persist($order);
            $listOrders[] = $order;
        }
        for ($i = 0; $i < 10; $i++) {
            $orderDetails = new OrderDetails();
            $orderDetails->setQuantity($faker->numberBetween(2, 10));
            $orderDetails->setPrice($faker->randomFloat(2, 1000, 9999));
            $orderDetails->setOrders($listOrders[array_rand($listOrders)]);
            $manager->persist($orderDetails);
        }

        for ($i = 0; $i < 3; $i++) {
            $orderReturns = new OrderReturns();
            $orderReturns->setReturncreatedate(new DateTimeImmutable());
            $manager->persist($orderReturns);
        }
        $listMessages = [];
        for ($i = 0; $i < 10; $i++) {
            $message = new Messages();
            $message->setSubjet($faker->sentence(3));
            $message->setDetails($faker->text(100));
            $message->setMessagecreatedate(new DateTimeImmutable());
            $message->setUsers($listUsers[array_rand($listUsers)]);
            $manager->persist($message);
            $listMessages[] = $message;
        }
        for ($i = 0; $i < 10; $i++) {
            $reply = new Reply();
            $reply->setSubject($faker->sentence(3));
            $reply->setDetails($faker->text(100));
            $reply->setReplyDate(new DateTimeImmutable());
            $reply->setMessages($listMessages[array_rand($listMessages)]);
            $reply->setUsers($listUsers[array_rand($listUsers)]);
            $manager->persist($reply);
        }
        for ($i = 0; $i < 20; $i++) {
            $review = new Reviews();
            $review->setNote($faker->randomDigit());
            $review->setComments($faker->text(80));
            $review->setCreatedat(new DateTimeImmutable());
            $review->setUsers($listUsers[array_rand($listUsers)]);
            $manager->persist($review);
        }


        $manager->flush();
    }
}
