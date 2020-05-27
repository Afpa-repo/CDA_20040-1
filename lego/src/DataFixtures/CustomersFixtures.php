<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Customers;
use App\Entity\Order;
use DateTime;
use Faker\Factory;

class CustomersFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();

        // Créer 10 clients fakés

        for($i = 1; $i <= 10; $i++)
        {
            $customer = new Customers();
            $customer->setDeliveryAddress($faker->address)
                ->setTel($faker->e164PhoneNumber)
                ->setMail($faker->email)
                ->setCity($faker->city);

            $manager->persist($customer);

            // Créer 3 à 5 commandes

            for($j = 1; $j <= mt_rand(3, 5); $j++)
            {
                $order = new Order();

                $date = new DateTime;
                $date->modify('+10 day');

                $order->setDeliveryAdress($customer->getDeliveryAddress())
                    ->setOrderDate($faker->dateTimeBetween('-6 months'))
                    ->setDeliveryDate($date)
                    ->setStatus("Réceptionné")
                    ->setShippingPrice($faker->randomFloat($nbMaxDecimals = 2))
                    ->setCustomer($customer);
                $manager->persist($order);

            }
        }

        $manager->flush();
    }
}
