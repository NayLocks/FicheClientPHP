<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use PDO;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class PDFController extends AbstractController
{
    /**
     * @Route("/test", name="dashboard")
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

        $test = $conn->query('SELECT * FROM fiche_client WHERE id = 65');
        $test = $test->fetchAll();

        return $this->render('GenPDF.html.twig', ['fiche' => $test[0]]);
    }

    /**
     * @Route("/{id}", name="pdf")
     */
    public function pdf(Request $request, $id)
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

        $test = $conn->query('SELECT * FROM fiche_client WHERE id = '.$id);
        $test = $test->fetchAll();

        $pdfOptions = new Options();
        $pdfOptions->set('isHtml5ParserEnabled', 'true');
        $pdfOptions->set('enable_remote', true);
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('GenPDF.html.twig', ['fiche' => $test[0]]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        $pdfFilepath =  $test['codeFiche'].'_'.$test[0]['nomAppel'].'.pdf';
        $path =  $test['codeFiche'].'_'.$test[0]['nomAppel'].'.pdf';
        file_put_contents($pdfFilepath, $output);

        return $this->redirect('/'.$pdfFilepath);
    }
}

