<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\State;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Count;

class StateController extends AbstractController
{
    /**
     * @Route(
     *     "/state/{country}",
     *     name="state",
     *     options = { "expose" = true }
     * )
     * @param Request $request
     * @param Country $country
     * @return Response
     */
    public function index(Request $request, Country $country): Response
    {
        if ($request->isXmlHttpRequest() === true) {
            $states = $country->getStates();
            $output = [];
            /** @var State $state */
            foreach ($states as $state) {
                $output[] = [
                    'id' => $state->getId(),
                    'name' => $state->getName(),
                ];
            }

            return new JsonResponse($output);
        }

        throw new BadRequestHttpException('Bad request');
    }

    /**
     * @Route("/country/{country}/cities/{state}", name="city", options = { "expose" = true })
     * @param Country $country
     * @param State $state
     * @param Request $request
     * @return JsonResponse
     */
    public function cities(Country $country, State $state, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $cities = $state->getCities();
            $output = [];
            foreach ($cities as $city) {
                $output[] = [
                    'id' => $city->getId(),
                    'name' => $city->getName(),
                ];
            }

            return new JsonResponse($output);
        }

        throw new BadRequestHttpException('Bad request');
    }
}
