<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class AccueilController extends AbstractController
{

    public function addRestaurant(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        //Initialisation 
        $task = new Task();

        //Création du tableau de restaurants
        $restaurants = array(1 => 'Burger King', 2 => 'Delarte', 3 => 'KFC', 4 => 'Subway');
        $restaurant =  $restaurants[array_rand($restaurants)];

        //Création du formulaire
        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class, ['label' => 'Nom du restaurant :'], ['attr' => ['placeholder' => "Titre du restaurant", 'class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer le restaurant'])
            ->getForm();

        $form->handleRequest($request);

        //Si le formulaire est valide on ajoute le nom du restaurant à la liste des restaurants
        if ($form->isSubmitted() && $form->isValid()) {

            //Enregistrement en BDD
            $em = $doctrine->getManager();

            if (array_push($restaurants, $form->get('task')->getData())) {
                $em->persist($task);
                $em->flush();
                $this->addFlash('notice', 'Restaurant enregistré!!');
            }
        }


        if (isset($_POST['go'])) {
            return $this->render('Accueil.html.twig', [
                'restaurant' => $restaurant,
            ]);
        }


        //Renvoi du modèle twig de la page d'accueil

        return $this->render('Accueil.html.twig', [
            'restaurant' => $restaurant,
            'restaurants' => $restaurants,
            'formRestaurant' => $form->createView(),
        ]);
    }
}
