<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Todo;
use App\Form\TodoType;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;

#[Route('/admin')]

class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $todos = $doctrine->getRepository(Todo::class)->findAll();
        $length = count($todos);
        $user = $this->getUser();
        return $this->render('todo/index.html.twig', ['todos' => $todos, "user"=> $user,"length" => $length]);
    }
  
    #[Route('/create', name: 'todo_create')]
    public function create(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        $todo = new Todo();
        $form = $this-> createForm(TodoType::class, $todo);

        $form->handleRequest($request);

        if ($form-> isSubmitted() && $form-> isValid()) {
            $todo = $form-> getData();
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureName = $fileUploader->upload($picture);
                $todo->setPicture($pictureName);
            }

            $em = $doctrine->getManager();
            $em->persist($todo);
            $em->flush();

            $this->addFlash(
                'notice',
                'New Student added'
            );

            return $this-> redirectToRoute('todo');
        }

        return $this->render('todo/create.html.twig',['form' => $form->createView()]);
    }
  
    #[Route('/edit/{id}', name: 'todo_edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, $id, FileUploader $fileUploader): Response
    {
        $todo = $doctrine->getRepository(Todo::class)->find($id);
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form-> isSubmitted() && $form-> isValid()) {
            $picturecurrent = $todo->getPicture();
            $todo = $form-> getData();
            $picture = $form->get('picture')->getData();
            if ($picture) {
                unlink($this->getParameter("pictures_directory") . $picturecurrent);
                $pictureName = $fileUploader->upload($picture);
                $todo->setPicture($pictureName);
            }
            
            $em = $doctrine->getManager();
            $em->persist($todo);
            $em->flush();
            $this->addFlash(
                'notice',
                'The Student was updated'
            );
            return $this->redirectToRoute('todo');
        }
        
        return $this->render('todo/edit.html.twig', ['form' => $form->createView()]);
    }
  
    #[Route('/details/{id}', name: 'todo_details')]
    public function details(ManagerRegistry $doctrine, $id): Response
    {
        $todo = $doctrine->getRepository(Todo::class)->find($id);
        $grades = $todo -> getfkGrades();
        return $this->render('todo/details.html.twig', ['todo' => $todo, 'grades' => $grades]);
    }

    #[Route('/delete/{id}', name: 'todo_delete')]
    public function delete(ManagerRegistry $doctrine, $id){
        $em = $doctrine->getManager();
        $todo = $doctrine->getRepository(Todo::class)->find($id);
        $picture = $todo->getPicture();
        if(file_exists($this->getParameter("pictures_directory") . $picture)){
            unlink($this->getParameter("pictures_directory") . $picture);
        }
        $em->remove($todo);
        
        $em->flush();
        $this->addFlash(
            'notice2',
            'Student has been Removed'
        );
        
        return $this->redirectToRoute('todo');
    }
    
}
