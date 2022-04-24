<?php

namespace App\Controller;

use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisController extends AbstractController
{
    public $form;

    /**
     * @Route("/avis/ajouter", name="avis/ajouter")
     */
    public function avisAjout(Request $request): Response
    {
        $this->CreateFormAjout();

        $word = "";
        if ($request->isMethod('POST'))
        {
            //Submit la form
            $this->form->submit($request->request->get($this->form->getName()));

            //Check si la form est valide
            if ($this->form->isSubmitted() && $this->form->isValid())
            {
                //Liste des mots bannis (majoritairement des insultes)
                $BannedWords = array("connard", "fils de pute", "fdp", "putain", "chier", "enculé", "abruti", "débile", "pute", "con", "connard", "connasse", "ta daronne", "merde", "salope", "sac à foutre", "sac a foutre", "salaud", "bz", "sperme", "bite", "pd");
                
                //Récupère les données de la form
                $entityManager = $this->getDoctrine()->getManager();
                $avis = $this->form->getData();

                //Parcours la liste des mots interdits et les cherche dans le titre et la description
                foreach($BannedWords as $BN){
                    if (str_contains(strtoupper($avis->getTitre()), strtoupper($BN)))
                        $word = $BN;
                    if (str_contains(strtoupper($avis->getCommentaire()), strtoupper($BN)))
                        $word = $BN;
                    //Si word est différent d'un string vide alors un mot a été détecté donc on sort de la boucle
                    if ($word !== "")
                        break;
                }

                //Si aucun mot détecté
                if ($word === ""){
                    //Ajoute les données à la BDD
                    $entityManager->persist($avis);
                    $entityManager->flush();

                    //Vide la form et la re-crée
                    unset($avis);
                    unset($form);
                    
                    $this->CreateFormAjout();

                    //Attend une demi seconde avant de redirect pour compenser le lag de l'envoi à la BDD
                    sleep(0.5);

                    //Redirige vers la liste d'avis
                    return $this->redirectToRoute('avis');
                }
                else {
                    $this->CreateFormAjout();
                }
            }
        }

        //Render la page d'ajout
        return $this->render('avis/avisAjout.html.twig', [
            'controller_name' => 'AvisController',
            'form' => $this->form->createView(),
            'error' => $word,
        ]);
    }

    /**
     * @Route("/avis", name="avis")
     */
    public function avis(): Response
    {
        //Fetch les données de la base
        $avis = $this->getDoctrine()->getRepository(Avis::class)->findAll();

        //Render la page d'affichage et passe les données fetch
        return $this->render('avis/avisListe.html.twig', [
            'controller_name' => 'AvisController',
            'avis' => $avis
        ]);
    }

    public function CreateFormAjout() : void {
        $avis = new Avis();
        unset($this->form);
        $newForm = $this->createFormBuilder($avis)
            ->add('nom_user', TextType::class, array('label' => 'Nom d\'utilisateur'))
            ->add('titre', TextType::class)
            ->add('commentaire', TextareaType::class)
            ->add('submit', SubmitType::class, ['label' => 'Ajouter l\'avis'])
            ->getForm();
        $this->form = $newForm;
        return;
    }
}
