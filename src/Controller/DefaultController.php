<?php

declare(strict_types=1);

namespace App\Controller;

//<editor-fold desc="Use statements">
use App\Entity\Payment;
use App\Entity\Sticker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Filesystem\Filesystem;
//</editor-fold>

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_page")
     *
     * @param ValidatorInterface $validator The validator service
     *
     * @return Response The response object
     *
     * @throws \Exception
     */
    public function index(ValidatorInterface $validator): Response
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
            ->setPayment((new Payment())->setPrice(750));

        $errors = $validator->validate($sticker);

        return $this->render('Default/index.html.twig', [
            'errors' => $errors,
        ]);
    }
}