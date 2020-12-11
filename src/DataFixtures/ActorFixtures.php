<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = ["Andrew Lincoln", "Norman Reedus", "Lauren Cohan", "Danai Gurira"];

    public function load(ObjectManager $manager)
    {
        $i=0;
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $actor->addProgram($this->getReference('program_' . rand(0,count(ProgramFixtures::PROGRAMS)-1)));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
            $i++;
        }

        for ($i = 4; $i < 50; $i++) {
            $actor = new Actor();
            $faker  =  Faker\Factory::create('fr_FR');
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference('program_' . rand(0,count(ProgramFixtures::PROGRAMS)-1)));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
