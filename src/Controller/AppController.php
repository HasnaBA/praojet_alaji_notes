<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class AppController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('app/home.html.twig');
    }

    
    /**
     * @Route("/login/user", name="user")
     */
    public function index(){
        return $this->render('app/index.html.twig', [
            'controller_name' => 'userController',
        ]);
    }
    
}
