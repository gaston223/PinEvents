<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET"})
     * @param PinRepository $pinRepository
     * @return Response
     */
    public function index(PinRepository $pinRepository):Response
    {
        $pins = $pinRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('pins/index.html.twig', compact('pins'));
    }


    /**
     * @Route("/pins/create", name="app_pins_create", methods={"GET|POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin;
        $form = $this->createFormBuilder($pin)
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $pin = $form->getData();
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/pin/{slug}", name="app_pin_show", methods={"GET"})
     * @param Pin $pin
     * @return Response
     */
    public function show(Pin $pin):Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }


    /**
     * @Route("/pin/{slug}/edit", name="app_pin_edit", methods={"GET|POST"})
     * @param Pin $pin
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Pin $pin, Request $request, EntityManagerInterface $em):Response
    {
        $form = $this->createFormBuilder($pin)
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $pin = $form->getData();
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/edit.html.twig', [
            'form'=> $form->createView(),
            'pin'=>$pin
        ]);
    }


}
