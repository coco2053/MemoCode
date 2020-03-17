<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article_show")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/add", name="article_add")
     * @Route("/article/{id}/edit", name="article_edit")
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $em)
    {
        if (!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }

            $em->persist($article);
            $em->flush();
            dump($article);

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }

        return $this->render('article/create.html.twig', [
                'form' => $form->createView(),
                'editMode' => $article->getId() !== null
            ]);
    }
}
