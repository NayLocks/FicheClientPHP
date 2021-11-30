<?php

namespace App\Controller;

use PDO;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class FicheArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index(Request $request)
    {

        try
        {
            $connexion_bdd = new PDO('sqlsrv:Server=192.168.1.233;Database=RIBEGROUPE', 'sa', '3Ribegroupe19!');
            $connexion_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $allFiches = $connexion_bdd->query('SELECT * FROM fiche_article AS fa JOIN societe AS s ON s.societe = fa.societe');
            $fiches = $allFiches->fetchAll();

        }
        catch(Exception $e)
        {
            echo("Error!");
        }

        return $this->render('Articles/index.html.twig', ['allFiches' => $fiches]);
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

