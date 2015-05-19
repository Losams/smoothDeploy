<?php

namespace Deploy\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Deploy\MainBundle\Entity\Environment;

class LoadEnvironmentData implements FixtureInterface
{
    /**
     * Load Environment data for start
     */
    public function load(ObjectManager $manager)
    {
        // DECLARATION
        $datas = array(
            array(
                'designation' => 'Production', 
                'defaultBranch' => 'master', 
            ),
            array(
                'designation' => 'Développement', 
                'defaultBranch' => 'develop', 
            ),
            array(
                'designation' => 'Sandbox', 
                'defaultBranch' => 'develop', 
            ),
        );

        // SAVE
        foreach ($datas as $data) {
            $env = new Environment();

            foreach ($data as $varName => $value) {
                $setter = 'set'.ucfirst(strtolower($varName));
                $env->{$setter}($value);
            }

            $manager->persist($env);
        }

        $manager->flush();
    }
}