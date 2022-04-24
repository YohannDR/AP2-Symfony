<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;


use App\Entity\Contact;
use App\Entity\Prestation;

class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        //return $this->render('contact/index.html.twig');
        return $this->redirectToRoute('prestation');
    }

    /**
     * @Route("/contact", name="contact_create")
     */
    public function create(Request $request): Response
    {
        $contact = new Contact();

        $manager = $this->getDoctrine()->getManager();
        
        $form = $this->createFormBuilder($contact)
                     ->add('nom')
                     ->add('prenom')
                     ->add('mail')
                     ->add('telephone')
                     ->add('description')
                     ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($contact);
            $manager->flush();
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/contact.html.twig', [
            'formContact' => $form->createView()
        ]);
    }
}
