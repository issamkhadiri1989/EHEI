<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RentController extends AbstractController
{
    /**
     * Retrieves all properties.
     *
     * @Route("/rent", name="rent")
     *
     * @param PropertyRepository $repository The repository instance
     *
     * @return Response The response instance
     */
    public function index(PropertyRepository $repository): Response
    {
        $rents = $repository->findBy([], ['price' => 'DESC']);

        return $this->render('rent/index.html.twig', [
            'rentals' => $rents,
        ]);
    }

    /**
     * Fetch only specific types.
     *
     * @Route("/rental/specific", name="specific")
     *
     * @param PropertyRepository $repository the repository instance
     *
     * @return Response The response instance
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function fetchSpecificTypesOnly(PropertyRepository $repository)
    {
        $types = ['Apartment', 'Studio'];
        $rents = $repository->getRentalsByTypes($types);
        $count = $repository->countAllProperties($types);

        return $this->render('rent/index.html.twig', [
            'rentals' => $rents,
            'count' => $count,
        ]);
    }

    /**
     * Fetch only  studios and apartments and only when < 1000 $.
     *
     * @Route("/rental/studios-apartments", name="custom")
     *
     * @param PropertyRepository $repository the repository instance
     *
     * @return Response The response instance
     */
    public function fetchStudiosAndApartmentOnly(PropertyRepository $repository)
    {
        $rents = $repository->getStudiosAndApartments(1800);

        return $this->render('rent/index.html.twig', [
            'rentals' => $rents,
        ]);
    }
}
