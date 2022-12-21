<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class AccueilController extends AbstractController
{
    public function Restaurants(): Response
    {
        //Création du tableau de restaurants
        $restaurants = array(1 => 'Burger King', 2 => 'Delarte', 3 => 'KFC', 4 => 'Subway');

        //Renvoi du modèle twig de la page d'accueil
        return $this->render('Accueil.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    public function addRestaurant(Request $request): Response
    {
        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('title')
            ->getForm();


        $form->handleRequest($request);


        return $this->render('Accueil.html.twig', [
            'formRestaurant' => $form->createView(),
        ]);
    }
}
