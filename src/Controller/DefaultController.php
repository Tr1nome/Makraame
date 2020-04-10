<?php
namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/", name="accueil")
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
    /**
     * @Route("/postitcollection", name="postit_collection", methods="GET")
     */
    public function getAllStickers(ImageRepository $imageRepo)
    {
        $stickers = $imageRepo->findBy(array('categories'=> 9));
        return $this->render('postit/index.html.twig', [
            'stickers' => $stickers
            
        ]);
    }
}