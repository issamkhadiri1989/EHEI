<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     *
     * @return Response the response object
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/view/article/{id}", name="view_article")
     *
     * @param Article $article the article instance
     *
     * @return Response the response object
     */
    public function view(Article $article): Response
    {
        return $this->render('article/view.html.twig', ['article' => $article]);
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY') and user === article.getAuthor()")
     *
     * @Route("/view/article/{id}/edit", name="edit_article")
     *
     * @param Request                $request the request
     * @param Article                $article the article instance
     * @param EntityManagerInterface $manager the entity manager
     *
     * @return Response the response object
     */
    public function edit(
        Request $request,
        Article $article,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /** @var UploadedFile $cover */
                $cover = $form->get('cover')
                    ->getData();
                if ($cover) {
                    $newFilename = \uniqid().'.'.$cover->guessExtension();
                    try {
                        if (true === \file_exists($old = \sprintf('%s/%s', $this->getParameter('media'), $article->getArticleCover()))) {
                            @\unlink($old);
                        }

                        $cover->move(
                            $this->getParameter('media'),
                            $newFilename
                        );
                        $article->setArticleCover($newFilename);
                    } catch (FileException $e) {
                    }
                }

                $manager->persist($article);
                $manager->flush();

                return $this->redirectToRoute('view_article', ['id' => $article->getId()]);
            }
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
