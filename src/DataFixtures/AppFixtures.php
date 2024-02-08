<?php

namespace App\DataFixtures;

use App\Story\DefaultCompanyStory;
use App\Story\DefaultUserStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // $manager->flush();


        DefaultCompanyStory::load();
        DefaultUserStory::load();
    }
}
