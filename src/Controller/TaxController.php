<?php

namespace App\Controller;

use App\Entity\CirculationTax;
use App\Form\Type\CirculationTaxType;
use App\Form\Type\EditTaxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaxController extends AbstractController
{
    /**
     * @Route("/tax", name="tax")
     *
     * @param Request                $request
     * @param EntityManagerInterface $manager
     *
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $tax = new CirculationTax();
        $tax->addHobby('natation')
            ->addHobby('musique')
            ->addHobby('football');


        $form = $this->createForm(CirculationTaxType::class, $tax);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tax);
            $manager->flush();

            return $this->redirectToRoute('tax', [], Response::HTTP_FOUND);
        }

        return $this->render('tax/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tax/{id}/edit", name="tax_edit")
     * @param CirculationTax $tax
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(CirculationTax $tax,  Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(EditTaxType::class, $tax);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tax);
            $manager->flush();

            return $this->redirectToRoute('tax', [], Response::HTTP_FOUND);
        }

        return $this->render('tax/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
