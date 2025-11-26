<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Flm;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    
        $faker=Factory::create("fr");

        $fichierFilmCsv=fopen(__DIR__."/film.csv","r");
        while(!feof($fichierFilmCsv)){
            $lesfilms[]=fgetcsv($fichierFilmCsv);

        }
        fclose($fichierFilmCsv);

        foreach($lesfilms as $value){
            $film =new Flm();
            $film   ->setId(intval($value[0]))                    
                    ->setTitre($value[1])             // titre
                    ->setDescription($value[2])       // description
                    ->setDuree((int) $value[3])       // durée
                    ->setDateSorti((int) $value[4]);   // date_sorti

            $manager->persist($film);
        }
        $manager->flush();
    }
}
