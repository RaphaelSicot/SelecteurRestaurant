<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AccueilController extends AbstractController
{

    public function addRestaurant(Request $request): Response
    {
        //Initialisation 
        $task = new Task();

        //Création du tableau de restaurants
        $restaurants = array(1 => 'Burger King', 2 => 'Delarte', 3 => 'KFC', 4 => 'Subway');


        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class, ['label' => 'Nom du restaurant :'])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer le restaurant'])
            ->getForm();

        //Création du tableau de restaurants
        $restaurants = array(1 => 'Burger King', 2 => 'Delarte', 3 => 'KFC', 4 => 'Subway');

        //Renvoi du modèle twig de la page d'accueil

        return $this->render('Accueil.html.twig', [
            'restaurants' => $restaurants,
            'formRestaurant' => $form->createView(),
        ]);
    }
}
