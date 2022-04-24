<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Prestation;

use App\Repository\PrestationRepository;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\PrestationType;
use App\Controller\CartController;


class PrestationController extends AbstractController
{
    /**
     * @Route("/prestation", name="prestation")
     */
    public function index(PrestationRepository $repo): Response
    {
        return $this->render('prestation/prestation.html.twig', [
            'controller_name' => 'PrestationController',
            'prestations' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/prestation/new", name="prestation_create")
     * @Route("/prestation/{id}/edit", name="prestation_edit")
     */
    public function form(Prestation $prestation = null, Request $request, EntityManagerInterface $manager) : Response
    {
        if (!$prestation) {
            $prestation = new Prestation();
        }
        $form = $this->createForm(PrestationType::class, $prestation);
        
        $form->handleRequest($request); // analyser la requette http 

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$prestation->getId()) {
                $prestation->setCreatedAt(new \DateTime());
            }
            $manager->persist($prestation);
            $manager->flush();

            return $this->redirectToRoute('prestation_show', ['id' => $prestation->getId()]);
        }

        return $this->render('prestation/create.html.twig', [
            'formPrestation' => $form->createView(),
            'editMode' => $prestation->getId() !== null
        ]);
    }

    /**
     * @Route("/prestation/{id}", name="prestation_show")
     */
    public function show(Prestation $prestation) : Response
    {
        return $this->render('prestation/show.html.twig', [
            'prestation' => $prestation
        ]);
    }
}
