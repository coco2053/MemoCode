<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_show")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/search", name="articles_search")
     */
    public function search(ArticleRepository $repo, Request $request)
    {
        $userId = null;
        $search = $request->request->get('search');
        $isChecked = $request->request->get('isChecked');

        if ($isChecked == "true") $userId = $this->getUser()->getId();

        $articles = $repo->findBeginWith($search, $userId);

        return $this->render('article/search_result.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/add", name="article_add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTime());
            $article->setUser($this->getUser());
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('articles_show');
        }

        return $this->render('article/create.html.twig', [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit")
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash(
                'notice',
                'Article modifié !'
            );
           return $this->redirectToRoute('articles_show');
        }
        return $this->render('article/edit.html.twig', [
                'form' => $form->createView(),
                'article' => $article
            ]);
    }

    /**
     * @Route("/article/{id}/delete", name="article_delete")
     */
    public function delete(Article $article, EntityManagerInterface $em)
    {
        $em->remove($article);
        $em->flush();

        $this->addFlash(
            'notice',
            'Article supprimé !'
        );
        return $this->redirectToRoute('articles_show');
    }

    /**
     * @Route("/article/{id}", name="article_show")
     *
     */
    public function show(Article $article)
    {
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }
    /**
     * @Route("/exists", name="article_exists")
     */
    public function exists(Request $request, ArticleRepository $repo)
    {
        // This is optional.
        // Only include it if the function is reserved for ajax calls only.
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'Error'),
            400);
        }

        if (isset($request->request)) {

            $articleName = $request->request->get('articleName');

            $article = $repo->findOneByTitleByUser($articleName, $this->getUser()->getId());

            if ($article === null) {
                return new JsonResponse(array(
                    'status' => 'OK',
                    'message' => 0),
                200);
            }
            else
            {
                return new JsonResponse(array(
                    'status' => 'OK',
                    'message' => 1),
                200);
            }
        }

        return new JsonResponse(array(
            'status' => 'Error',
            'message' => 'Error'),
        400);
    }
}
