<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        $user = $this->getUser();
        return $this->render('index.html.twig', compact('user'));
    }

    #[Route('/profil', name: 'profil', methods: ['GET'])]
    public function profil()
    {
        $user = $this->getUser();
        $recipes = $user->getRecipes();
        $ingredients = $user->getIngredients();
        return $this->render('profil.html.twig', compact('user', 'recipes', 'ingredients'));
    }
}
