<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Image;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\ImageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository, ImageRepository $imageRepo, Request $request): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'images'=> $imageRepo->findAll()
            
        ]);
    }


    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $file = $form
                ->get('image')
                ->get('file')
                ->getData();
            if ($file) {
                $image = new Image();
                $fileName =
                    $this->generateUniqueFileName() .
                    '.' .
                    $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $image->setPath(
                    $this->getParameter('images_directory') . '/' . $fileName
                );
                $image->setImgPath(
                    $this->getParameter('images_path') . '/' . $fileName
                );
                $entityManager->persist($image);
                $article->setImage($image);
            } else {
                $article->setImage(null);
            }
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('article_index');
        }
        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/newP", name="postit", methods={"GET","POST"})
     */
    public function create(
        Request $request,
        ImageRepository $imageRepo
    ): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $title = $request->get('title');
        $content = $request->get('content');
        $color = $request->get('color');
        $posX = $request->get('positionx');
        $posY = $request->get('positiony');
        $creation = $request->get('creation');
        $author = $request->get('author');
        $article = new Article();
        $article->setTitle($title);
        $article->setContent($content);
        $article->setColor($color);
        $article->setPositionx($posX);
        $article->setPositiony($posY);
        $article->setCreation($creation);
        $article->setCreator($author);
        
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/updatePos", name="updatePostit", methods={"GET","POST"})
     */
    public function Update(Request $request, Article $article): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $posX = $request->get('positionx');
        $posY = $request->get('positiony');
        $article->setPositionx($posX);
        $article->setPositiony($posY);
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('article_index');

    }
    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $image = $article->getImage();
            $file = $form
                ->get('image')
                ->get('file')
                ->getData();
            if ($file) {
                $fileName =
                    $this->generateUniqueFileName() .
                    '.' .
                    $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $this->removeFile($image->getPath());
                $image->setPath(
                    $this->getParameter('images_directory') . '/' . $fileName
                );
                $image->setImgpath(
                    $this->getParameter('images_path') . '/' . $fileName
                );
                $entityManager->persist($image);
            }
            if (empty($image->getId()) && !$file) {
                $article->setImage(null);
            }
            $this->getDoctrine()
                ->getManager()
                ->flush();
            return $this->redirectToRoute('article_index', [
                'id' => $article->getId()
            ]);
        }
        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if (
            $this->isCsrfTokenValid(
                'delete' . $article->getId(),
                $request->request->get('_token')
            )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    private function removeFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
