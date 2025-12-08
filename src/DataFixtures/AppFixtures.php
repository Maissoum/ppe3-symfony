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

        $imageNum = 1; // compteur pour les images

        while (($data = fgetcsv($fichierFilm)) !== false) {
            if (count($data) < 5) continue;

            $film = new Flm();
            $film->setTitre($data[1])
                ->setDescription($data[2])
                ->setDuree((int)$data[3])
                ->setDateSorti((int) explode('-', $data[4])[0]) // juste l'année
                ->setImage("https://lorempicture.point-sys.com/400/300/ville/$imageNum/");

            // Incrémenter et revenir à 1 si > 30
            $imageNum++;
            if ($imageNum > 30) $imageNum = 1;

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

                /* ------------------------
            4) Import des ABONNEMENTS
        ------------------------ */
        $fichierAbo = fopen(__DIR__ . "/abonnement.csv", "r");

        while (($data = fgetcsv($fichierAbo, separator: ";")) !== false) {

            if (count($data) < 5) continue;

            $abo = new \App\Entity\Abonnement();
            $abo->setNom($data[1])
                ->setPrix((float)$data[2])
                ->setDuree((int)$data[3])
                ->setDescription($data[4]);

            $manager->persist($abo);
        }

        fclose($fichierAbo);




        $manager->flush();







    }

    


}
