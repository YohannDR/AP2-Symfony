<?php

namespace App\Controller;

use App\Entity\Identite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LegalController extends AbstractController
{
    /**
     * @Route("/legal", name="legal")
     */
    public function legalDisplay(Request $request)
    {
        $legalInfo = $this->getDoctrine()->getRepository(Identite::class)->findAll();
        return $this->render('legal/display.html.twig', [
            'controller_name' => 'LegalController',
            'info' => $legalInfo[0]
        ]);
    }

    /**
     * @Route("/legal/edit", name="legal/edit")
     */
    public function legalEdit(Request $request)
    {
        $identite = new Identite();
        $newForm = $this->createFormBuilder($identite)
            ->add('nom', TextType::class, array('label' => 'Nom du site web'))
            ->add('adresse', TextType::class, array('label' => 'Adresse du site'))
            ->add('proprietaire', TextType::class, array('label' => 'Propriétaire du site'))
            ->add('responsablePublication', TextType::class, ['label' => 'Responsable de publication'])
            ->add('concepteur', TextType::class, ['label' => 'Concepteur'])
            ->add('animation', TextType::class, ['label' => 'Animateur'])
            ->add('hebergeur', TextType::class, ['label' => 'Hébergeur'])
            ->add('submit', SubmitType::class, ['label' => 'Modifier les données'])
            ->getForm();
        $legalInfo = $this->getDoctrine()->getRepository(Identite::class)->findAll()[0];
        $newForm->get('nom')->setData($legalInfo->getNom());
        $newForm->get('adresse')->setData($legalInfo->getAdresse());
        $newForm->get('proprietaire')->setData($legalInfo->getProprietaire());
        $newForm->get('responsablePublication')->setData($legalInfo->getResponsablePublication());
        $newForm->get('concepteur')->setData($legalInfo->getConcepteur());
        $newForm->get('animation')->setData($legalInfo->getAnimation());
        $newForm->get('hebergeur')->setData($legalInfo->getHebergeur());

        if ($request->isMethod('POST'))
        {
            $newForm->submit($request->request->get($newForm->getName()));
            if ($newForm->isSubmitted() && $newForm->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();
                $oldInfo = $this->getDoctrine()->getRepository(Identite::class)->findAll()[0];
                $entityManager->remove($oldInfo);
                $entityManager->flush();
                $newInfo = $newForm->getData();
                $entityManager->persist($newInfo);
                $entityManager->flush();
                return $this->redirectToRoute('legal');
            }
        }

        return $this->render('legal/edit.html.twig', [
            'controller_name' => 'LegalController',
            'form' => $newForm->createView()
        ]);
    }
}
