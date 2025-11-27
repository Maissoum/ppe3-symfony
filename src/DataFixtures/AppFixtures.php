<?php

namespace App\DataFixtures;

use App\Entity\Flm;
use App\Entity\Cat;
use App\Entity\Avis;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /* -------------------------
            1) Import des CATEGORIES
        ------------------------- */
        $categories = [];
        $fichierCat = fopen(__DIR__ . "/categorie.csv", "r");

        while (($data = fgetcsv($fichierCat)) !== false) {
            if (count($data) < 4) continue;

            $cat = new Cat();
            $cat->setNom($data[1])
                ->setDescription($data[2])
                ->setCouleur($data[3]);

            $manager->persist($cat);
            $categories[$data[0]] = $cat; // id => objet
        }
        fclose($fichierCat);

        /* ---------------------
            2) Import des FILMS
        --------------------- */
        $films = [];
        $fichierFilm = fopen(__DIR__ . "/film.csv", "r");

        while (($data = fgetcsv($fichierFilm)) !== false) {
            if (count($data) < 5) continue;

            $film = new Flm();
            $film->setTitre($data[1])
                ->setDescription($data[2])
                ->setDuree((int)$data[3])
                ->setDateSorti((int) str_replace("-", "", $data[4])) // ou autre format
                ->setImage("https://via.placeholder.com/200"); // car image obligatoire

            // ❗ AFFECTER 1 à 3 catégories aléatoires
            $nbCat = rand(1, 3);
            $keys = array_rand($categories, $nbCat);

            if (!is_array($keys)) $keys = [$keys];

            foreach ($keys as $k) {
                $film->addCat($categories[$k]);
            }

            $manager->persist($film);
            $films[$data[0]] = $film; // id => objet film
        }

        fclose($fichierFilm);

        /* -------------------
            3) Import des AVIS
        ------------------- */
        $fichierAvis = fopen(__DIR__ . "/avis.csv", "r");

        while (($data = fgetcsv($fichierAvis)) !== false) {
            if (count($data) < 4) continue;

            $avis = new Avis();
            $avis->setNote((int)$data[2])
                 ->setCommentaire($data[3]);

            // lien vers un film existant
            $idFilm = $data[1];
            if (isset($films[$idFilm])) {
                $avis->setFlms($films[$idFilm]);
            }

            $manager->persist($avis);
        }

        fclose($fichierAvis);

        $manager->flush();
    }
}
