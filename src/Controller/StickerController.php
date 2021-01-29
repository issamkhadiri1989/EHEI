<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\Sticker;
use App\Form\StickerType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;

class StickerController extends AbstractController
{
    /**
     * @Security("is_granted('ISIS_AUTHENTICATED_FULLY')")
     * @Route("/show-all", name="show_all")
     */
    public function showAll()
    {
    }

    /**
     * @Security(
     *     "is_granted('IS_AUTHENTICATED_FULLY') and user === sticker.getUser()",
     *     message="You don't have enough privileges to access to this resource"
     * )
     *
     * @Route("/show/{id}", name="show_sticker")
     *
     * @param Sticker $sticker The sticker to update
     *
     * @return Response
     */
    public function show(Sticker $sticker): Response
    {
        return $this->render('Sticker/show.html.twig', [
            'sticker' => $sticker,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/new", name="new_sticker")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     *
     * @return Response
     */
    public function save(Request $request, EntityManagerInterface $manager)
    {
        $sticker = new Sticker();
        $sticker->setUser($this->getUser());
        $form = $this->createForm(StickerType::class, $sticker);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $manager->persist($sticker);
                $manager->flush();

                return $this->redirectToRoute('show_sticker', ['id' => $sticker->getId(),]);
            }
        }

        return $this->render('Sticker/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/payment", name="payment")
     *
     * @param ValidatorInterface $validator
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function payment(ValidatorInterface $validator): Response
    {
        $sticker = new Sticker();
        $sticker
            ->setDriverName('TEST')
            ->setRegistrationNumber('51953-A-7')
            ->setCirculationDate(new \DateTime('2009-07-14'))
            ->setFiscalPower(6)
            ->setFuel('Diesel')
            ->setYear(2019)
            ->addDriverData('driver_card', '4111111111111111')
            ->setPhoneNumber('0601020304')
            ->setUser($this->getUser())
            ->setPayment((new Payment())->setPrice(750));

        $errors = $validator->validate($sticker);

        return $this->render('Default/index.html.twig', [
            'errors' => $errors,
        ]);
    }
}