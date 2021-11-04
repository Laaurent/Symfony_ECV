<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {
    public function index() {
        $user = $this->getUser();
        return $this->render('index.html.twig', ['user' => $user]);
    }
}