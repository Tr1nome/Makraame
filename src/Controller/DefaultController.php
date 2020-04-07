<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/", name="accueil", host="leo-souly-modula.fr")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index_1")
     */
    public function index()
    {
        return $this->render('default/index.html.twig');

    }
}