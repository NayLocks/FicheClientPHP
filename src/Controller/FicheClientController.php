<?php

namespace App\Controller;

use PDO;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class FicheClientController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(Request $request)
    {
        $host = '192.168.1.249';
        $dbname = 'fiche_client';
        $username = 'ribegroupe';
        $password = '3Ribegroupe21!';

        try {

            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


        } catch (PDOException $e) {

            die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

        }

        $allFiches = $conn->query('SELECT * FROM fiche_client ORDER BY societe, validType ASC');
        $fiches = $allFiches->fetchAll();

        return $this->render('index.html.twig', ['allFiches' => $fiches]);
    }

    /**
     * @Route("/index/{id}", name="indexId")
     */
    public function fiche_client(Request $request, $id)
    {
        $host = '192.168.1.249';
        $dbname = 'fiche_client';
        $username = 'ribegroupe';
        $password = '3Ribegroupe21!';

        try {

            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


        } catch (PDOException $e) {

            die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());

        }

        $allFiches = $conn->query('SELECT * FROM fiche_client WHERE id = '.$id);
        $fiche = $allFiches->fetchAll();

        return $this->render('fiche_client.html.twig', ['fiche' => $fiche[0]]);
    }
}

