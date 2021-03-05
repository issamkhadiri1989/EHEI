<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        //<editor-fold desc="Generate categories">

        $categories = $this->getCategories();
        foreach ($categories as $i => $label) {
            $category = new Category();
            $category->setName($label);
            $manager->persist($category);
            $this->addReference(\sprintf('CAT%d', $i), $category);
        }

        //</editor-fold>

        //<editor-fold desc="Generate some authors">

        for ($i = 1; $i <= 5; $i++) {
            $author = new Author();
            $author->setName($this->faker->firstName() . ' ' . $this->faker->lastName())
                ->setBio($this->faker->paragraph(2));
            $manager->persist($author);
            $this->addReference(\sprintf('AUT%d', $i), $author);
        }

        //</editor-fold>

        //<editor-fold desc="Generate some books">

        for ($i = 0; $i < 10; $i++) {
            /** @var Author $author */
            $author = $this->getReference(\sprintf(
                'AUT%d',
                \rand(1, 3)
            ));
            /** @var Category $category */
            $category = $this->getReference(\sprintf(
                'CAT%d',
                \rand(0, \count($categories) - 1)
            ));

            $book = new Book();
            $book->setCategory($category)
                ->setAuthor($author)
                ->setTitle($this->faker->sentence(10))
                ->setEdition((string) \rand(1819, 1970))
                ->setIntroduction($this->faker->paragraph(3))
                ->setNbPages(\rand(100, 250))
                ->setCover('https://picsum.photos/400')
                ->setPubDate(new \DateTime($this->faker->date('Y-m-d', '-10y')));
            $manager->persist($book);
        }

        //</editor-fold>

        //<editor-fold desc="Generate properties">

        $types = ['Apartment', 'Studio', 'Duplex', 'House'];
        for ($i = 0; $i < 10; $i++) {
            $property = new Property();
            $property->setOwner($this->faker->firstName().' '.$this->faker->lastName())
                ->setDescription($this->faker->paragraph(4))
                ->setPubDate(new \DateTime($this->faker->date('Y-m-d', '-1 y')))
                ->setLocation($this->faker->paragraph(1))
                ->setNbRooms(\rand(2, 4))
                ->setTitle($this->faker->sentence(10))
                ->setMainCover('https://picsum.photos/400')
                ->setPrice($this->faker->randomFloat(2, 700, 2600))
                ->setPropertyType($types[\rand(0, \count($types) - 1)]);
            $manager->persist($property);
        }

        //</editor-fold>

        $manager->flush();
    }

    /**
     * Retrieves all possible categories.
     *
     * @return array list of categories
     */
    private function getCategories(): array
    {
        return [
            'Action and Adventure',
            'Classics',
            'Detective and Mystery',
            'Fantasy',
            'Historical Fiction',
            'Horror',
        ];
    }
}
