<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;




class AccueilController extends AbstractController
{
    public function array(): Response
    {
        //Création du tableau de restaurants
        $restaurants = array(1 => 'Burger King', 2 => 'Delarte', 3 => 'KFC', 4 => 'Subway');

        //Renvoi du modèle twig de la page d'accueil
        return $this->render('Accueil.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    public function new(Request $request): Response
    {
        $task = new Task();
        $task->setTask('Write a blog post');


        $form =  $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);


        return $this->render('Formulaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
