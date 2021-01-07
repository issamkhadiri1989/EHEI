<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\City;
use App\Entity\Registration;
use App\Form\RegistrationType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{
    /**
     * @param array $data A cities object
     *
     * @return array The list of cities converted to a simple array
     */
    private function convertToArray(array $data)
    {
        $output = [];
        /** @var City $item */
        foreach ($data as $item) {
            $output[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
            ];
        }

        return $output;
    }
    /**
     * @Route("/cities", name="cities", options={"expose"=true})
     *
     * @param Request $request The request instance
     * @param CityRepository $repository The city's repository instance
     *
     * @return JsonResponse A response
     */
    public function retrieveCity(Request $request, CityRepository $repository): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->isMethod('post')) {
                $country = $request->request->get('country');
                $cities = $repository->findByCountry($country);

                return new JsonResponse($this->convertToArray($cities));
            }
        }

        // Simply throw a 404 error.
        throw new $this->createNotFoundException('Page not found');
    }

    /**
     * @Route("/", name="default")
     *
     * @param Request                $request The request object
     * @param EntityManagerInterface $manager An entity manager instance
     *
     * @return Response The response object
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $registration = new Registration();
        $form = $this->createForm(RegistrationType::class, $registration);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $manager->persist($registration);
                $manager->flush();

                return $this->redirectToRoute('default');
            }
        }

        return $this->render('Default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
