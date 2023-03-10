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


    // Fonction d'ajout de restaurant
    public function addRestaurant(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        //Initialisation des variables
        $task = new Task();
        $restaurant = '';

        // Référentiel permettant 
        $repository = $doctrine->getRepository(Task::class);

        // Récupération de tout les restaurants de la BDD 
        $restaurants = $repository->findAll();

        //Création du formulaire
        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class, ['label' => 'Nom du restaurant :'], ['attr' => ['placeholder' => "Titre du restaurant", 'class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer le restaurant'])
            ->getForm();

        //Gestion traitement de la saisie du formulaire
        $form->handleRequest($request);

        //Si le formulaire est valide on ajoute le nom du restaurant à la liste des restaurants
        if ($form->isSubmitted() && $form->isValid()) {

            //Enregistrement en BDD
            $em = $doctrine->getManager();

            if (array_push($restaurants, $form->get('task')->getData())) {
                $em->persist($task);
                $em->flush();
                $task = new Task();
                $form = $this->createFormBuilder($task)
                    ->add('task', TextType::class, ['label' => 'Nom du restaurant :'], ['attr' => ['placeholder' => "Titre du restaurant", 'class' => 'form-control']])
                    ->add('save', SubmitType::class, ['label' => 'Enregistrer le restaurant'])
                    ->getForm();

                // return $this -> redirectToRoute('/Accueil)
            }
        }

        //On clique sur le bouton pour pouvoir lancer une sélection aléatoire d'un restaurant
        // if (isset($_POST['go'])) {

        //     $restaurant =  $restaurants[array_rand($restaurants)];
        // }
        //Renvoi du modèle twig de la page d'accueil

        return $this->render('Accueil.html.twig', [
            'restaurant' => $restaurant,
            'restaurants' => $restaurants,
            'formRestaurant' => $form->createView(),
        ]);
    }
}
