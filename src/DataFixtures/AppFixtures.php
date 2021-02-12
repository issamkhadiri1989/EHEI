<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $articles = $this->articles();
        foreach ($articles as $article) {
            $manager->persist($article);
        }
        $blog = new Blog();
        $blog->setTitle($this->faker->sentence())
            ->setContent($this->faker->paragraph(20));
        $manager->persist($blog);
        $manager->flush();
    }

    private function articles()
    {
        return [
            (new Article())
                ->setContent($this->faker->paragraph(10))
                ->setTitle($this->faker->sentence(10))
                ->setPubYear($this->faker->year(2020)),
            (new Article())
                ->setContent($this->faker->paragraph(15))
                ->setTitle($this->faker->sentence(10))
                ->setPubYear($this->faker->year(1999)),
        ];
    }
}
