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

        $search = $request->request->get('search');
        //$articles = $repo->findAll();

        $articles = $repo->findBeginWith($search);
        //var_dump($search);
        //var_dump($articles);

        return $this->render('article/search_result.html.twig', [
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

            /*$divs =  $request->request->get('formdiv');
            if (!empty($divs)) {
                $pieces = explode(",", $divs);
                $memos = $article->getMemos();
                $texts = $article->getTexts();
                foreach ($memos as $key => $memo) {
                    foreach ($pieces as $piece) {
                        if ($piece == $key) $memo->setText($texts[$key]);
                    }
                }
            }*/

            $em->persist($article);
            $em->flush();
            //dd($article);

            return $this->redirectToRoute('articles_show');
        }

        return $this->render('article/create.html.twig', [
                'form' => $form->createView(),
                'editMode' => $article->getId() !== null
            ]);
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

            $article = $repo->findOneByTitle($articleName);

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
