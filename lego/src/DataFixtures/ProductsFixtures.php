<?php

namespace App\DataFixtures;

use App\Entity\Suppliers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Products;
use Faker\Factory;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();


        for ($j = 1; $j <= 3; $j++) {
            $supplier = new Suppliers();

            $supplier->setCompagnyName($faker->name)
                ->setHeadOffice($faker->streetAddress)
                ->setTel("01 45 14 13 24")
                ->setCity($faker->city)
                ->setMail($faker->email);

            $manager->persist($supplier);

            for ($i = 1; $i <= 12; $i++)

            {
                $product = new Products();
                $product->setWording($faker->sentence())
                    ->setRef($faker->word)
                    ->setPrice($faker->randomFloat(2, 20, 100))
                    ->setAge($faker->numberBetween(1, 12))
                    ->setDescription($faker->text())
                    ->setImage($faker->imageURL())
                    ->setSupplier($supplier);


                $manager->persist($product);
            }



        }


        $manager->flush();
    }
}
