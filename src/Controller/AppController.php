<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;

use App\Entity\Student;
use App\Entity\Quiz;
use App\Entity\Result;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
Use App\Controller\RedirectResponse;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class AppController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('app/home.html.twig');
    }


    /**
     * @Route("/login/user", name="user")
     */
    public function index()
    {
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
    public function quizzes()
    {
        $repo = $this->getDoctrine()->getRepository(Quiz::class);
        $quizzes = $repo->findAll();
        return $this->render('app/quizzes.html.twig', [
            'controller_name' => 'Controller', 'SecurityController',
            'quizzes' => $quizzes
        ]);
    }


    /**
     * @Route("/quiz/{idQuiz}/candidats", name="candidats")
     */
    public function students(int $idQuiz)
    {
        $repo = $this->getDoctrine()->getRepository(Quiz::class);
        $quiz = $repo->find($idQuiz);

        $repo = $this->getDoctrine()->getRepository(Student::class);
        $students = $repo->findAll();

        return $this->render('app/students.html.twig', [
            'quiz' => $quiz,
            'students' => $students,
        ]);
    }

    /**
     * @Route("/quiz/{idQuiz}/candidats/{idCandidat}", name="candidat_show")
     */
    public function showStudent(int $idCandidat, int $idQuiz, Request $reSquest)

    {   




        $repo = $this->getDoctrine()->getRepository(Quiz::class);
        $quiz = $repo->find($idQuiz);

        $repo = $this->getDoctrine()->getRepository(Student::class);
        $student = $repo->find($idCandidat);

        $repo = $this->getDoctrine()->getRepository(Result::class);
        $results = [];
        foreach ($quiz->getCriterias() as $criteria) {
            $results[] = $repo->findOneBy([
                'student' => $student,
                'criteria' => $criteria
            ]);
        }

        //création du form pour entrer les résultats du test à l'oral

        $resultTest = new Result();
        $formTest = $this->createFormBuilder($resultTest)
            ->add('interview', ChoiceType::class, [
                'label' => 'Note',
                'placeholder' => 'choisir la note',
                'choices'=> [
                '0' => 'false',
                '1' => 'true'
                ],
            ])
            ->add('criteria', ChoiceType::class, [
                'label' => 'Question',
                'choices'=> [
                '1' => 'true',
                '2' => 'true',
                '3' => 'true',
                '4' => 'true'
                ],
            ])
            
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
  
            ->getForm();
            
            /*$formTest->handleRequest($request);

        *if ($formTest->isSubmitted() && $formTest->isValid()) {
        $data = $formTest->getData();

        $response = new RedirectResponse('/task/success');
        $response->prepare($request);

    return $response->send();*/
       
        return $this->render('app/showStudent.html.twig', [
            'student' => $student,
            'quiz' => $quiz,
            'criteria' => $criteria,
            'results' => $results,
            'formTest' => $formTest->createView()
        ]);



        
    }
}
