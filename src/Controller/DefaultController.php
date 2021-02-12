<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Blog;
use App\Repository\ArticleRepository;
use App\Repository\BlogRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     *
     * @param Request $request The request instance
     * @param ArticleRepository $repository The article repository object
     * @param BlogRepository $blogRepository The blog repository blog
     *
     * @return Response The response
     */
    public function index(
        Request $request,
        ArticleRepository $repository,
        BlogRepository $blogRepository
    ): Response
    {
        $articles = $repository->findAll();
        $blogs = $blogRepository->findAll();

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'blogs' => $blogs,
        ]);
    }

    /**
     * This action uses the ParamConverter to fetch automatically the Article object.
     *
     * @Route("/article/view-id/{id}", name="view_with_id")
     *
     * @param Article $article The article instance
     */
    public function viewArticle(Article $article)
    {
        dd($article);
    }

    /**
     * Find the Article object using a specific unique attribute.
     *
     * @Route("/article/view-with-slug/{slug}", name="view_with_slug")
     *
     * @param Article $article The article instance
     */
    public function viewArticleBySlug(Article $article)
    {
        dd($article);
    }

    /**
     * Fetch the Blog object using the repository.
     *
     * @Route("/blog/view-with-entity/{blog_id}", name="view_with_entity")
     *
     * @Entity("blog", expr="repository.find(blog_id)")
     *
     * @param Blog $blog The blog instance
     */
    public function viewBlogByEntity(Blog $blog)
    {
        dd($blog);
    }

    /**
     * Fetches multiples objects using route variables and ParamConverter / Entity.
     *
     * @Route("/blog/{id}/article/{article_id}", name="view_blog_article")
     *
     * @Entity("article", expr="repository.find(article_id)")
     *
     * @param Blog $blog The blog instance
     * @param Article $article The article instance
     */
    public function viewBlogAndArticle(Blog $blog, Article $article)
    {
        dump($blog);
        dump($article);
        die;
    }

    /**
     * Fetches the Article object using options.
     *
     * @Route("/article/view-option-id/{article_id}", name="view_article_with_id_option")
     *
     * @ParamConverter("article", options={"id"="article_id"})
     *
     * @param Article $article The article instance
     */
    public function viewArticleWithOptions(Article $article)
    {
        dd($article);
    }

    /**
     * Fetches objects using mapping between route parameters and entities attributes.
     *
     * @Route("/blog/{blog_slug}/articles/{year}/{article_id}", name="view_with_mapping_option")
     *
     * @ParamConverter("blog", options={"mapping": {"blog_slug" : "slug"}})
     * @ParamConverter("article", options={"mapping" : {"year": "pubYear", "article_id": "slug"}})
     *
     * @param Blog $blog The blog instance
     * @param Article $article The article instance
     */
    public function viewArticleAndBlogUsingMapping(Blog $blog, Article $article)
    {
        dump($blog);
        dump($article);
        die;
    }

    /**
     * Fetches the Article entity by excluding some route's variables.
     *
     * @Route("/article/view/{year}/{slug}", name="view_with_exclude")
     *
     * @ParamConverter("article", options={"mapping": {"year": "pubYear", "slug": "slug"}, "exclude": {"year"}})
     *
     * @param int $year The publishing year
     * @param Article $article The article instance
     */
    public function viewArticleWithExcludingYear(int $year, Article $article)
    {
        dd($article);
    }

    /**
     * Fetches object when strip_null is set to true.
     *
     * @Route("/route-strip-null/article/view/{slug}/{year}", name="view_with_strip_null")
     *
     * @ParamConverter(
     *     "article",
     *     options={
     *          "mapping": {"year": "pubYear", "slug": "slug"},
     *          "strip_null": true
     *     }
     * )
     *
     * @param Article $article The article instance
     * @param int $year The publishing year
     */
    public function viewArticleWithStripNull(Article $article, int $year = null)
    {
        dd($article);
    }

    /**
     * Fetches object using another entity manager test
     *
     * @Route("/blog/{id}", name="view_entity_manager")
     *
     * @ParamConverter("article", options={"entity_manager" : "test"})
     *
     * @param Blog $blog The blog instance
     */
    public function viewArticleWithAnotherEntityManager(Blog $blog)
    {
    }

    /**
     * Converting parameters to dates.
     *
     * @Route("/book/from/{from}/to/{to}", name="book")
     *
     * @param \DateTime $from The starting date
     * @param \DateTime $to   The ending date
     */
    public function convertToDate(\DateTime $from, \DateTime $to)
    {
        dump($from);
        dump($to);
        die;
    }

    /**
     * @Route("/book-specific/{start}", name="book_specific_format")
     *
     * @ParamConverter("start", options={"format": "Ymd"})
     *
     * @param \DateTime $start The starting date
     */
    public function convertToDateWithSpecificOptions(\DateTime $start)
    {
        dd($start);
    }
}
