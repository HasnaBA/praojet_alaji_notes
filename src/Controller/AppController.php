<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Student;
use App\Entity\Quiz;
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
        $repo = $this->getDoctrine()->getRepository(Quiz::class); 
        $users = $repo->findAll();
        return $this->render('app/index.html.twig', [
            'controller_name' => 'userController',
            'users' => $users
        ]);
    }
    /**
     * @Route("/quizzes", name="quizzes")
     */
    public function quizzes(){
        $repo = $this->getDoctrine()->getRepository(Quiz::class); 
        $quizzes = $repo->findAll();
        return $this->render('app/quizzes.html.twig',[
            'controller_name' => 'Controller', 'SecurityController',
            'quizzes' => $quizzes
        ]);
    }

   
    /**
     * @Route("/quiz/candidats", name="candidats")
     */
    public function students(){
        $repo = $this->getDoctrine()->getRepository(Student::class); 
        $students = $repo->findAll();
        return $this->render('app/students.html.twig',[
            'students' => $students
        ]);
    }


}
