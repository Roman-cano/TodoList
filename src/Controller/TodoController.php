<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoSearch;
use App\Form\TodoType;
use App\Repository\TodoRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/todo")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/", name="app_todo_index", methods={"GET", "POST"})
     */
    public function index(Request $request, TodoRepository $todoRepository): Response
    {
        // Créer le formulaire de recherche
        $form = $this->createForm(TodoSearch::class);

        // Traitement du formulaire
        $form->handleRequest($request);

        // Récupérer les critères de recherche
        $libelle = $form->get('libelle')->getData();


        // Requête avec filtrage si des critères sont définis
        if ($form->isSubmitted() && $form->isValid()) {
            $todos = $todoRepository->findBySearchCriteria($libelle);
        } else {
            $todos = $todoRepository->findAll();  // Retourner tous les Todo si pas de filtre
        }

        return $this->render('todo/index.html.twig', [
            'todos' => $todos,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/todo/{id}/user", name="app_todo_show_user")
     */
    public function showUser(Todo $todo): Response
    {
        // Tu peux ajouter la logique pour récupérer l'utilisateur associé à cette tâche si nécessaire.
        // Par exemple, pour afficher les utilisateurs associés à cette tâche :
        $users = $todo->getUsers();

        // Afficher la page avec les informations de la tâche et des utilisateurs associés
        return $this->render('todo/show_user.html.twig', [
            'todo' => $todo,
            'users' => $users,
        ]);
    }


/**
 * @Route("/sort/{etat}", name="app_todo_sort", methods={"GET"})
 */
public function sortByEtat(string $etat, TodoRepository $todoRepository): Response
{
    $todos = $todoRepository->findBy(['etat' => $etat]);

    return $this->render('todo/index.html.twig', [
        'todos' => $todos,
    ]);
}


    /**
     * @Route("/new", name="app_todo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TodoRepository $todoRepository): Response
    {
        $todo = new Todo();

        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $form->get('users')->getData();
            foreach ($users as $user) {

                $user->addTodo($todo);
                $todo->addUser($user); // Ajoute l'utilisateur à la tâche
            }
            $todoRepository->add($todo, true);


            return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/new.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_todo_show", methods={"GET"})
     */
    public function show(Todo $todo): Response
    {
        return $this->render('todo/show.html.twig', [
            'todo' => $todo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_todo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        $users = $form->get('users')->getData();
        $lesUti = $todo->getUsers();

        foreach ($users as $user) {

            $user->addTodo($todo);
            $todo->addUser($user); // Ajoute l'utilisateur à la tâche
        }
        $todoRepository->add($todo, true);

        return $this->renderForm('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_todo_delete", methods={"POST"})
     */
    public function delete(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $lesUtilisateurs = $todo->getUsers();
            foreach($lesUtilisateurs as $utilisateur) {
                $todo->removeUser($utilisateur);
            }
            $todoRepository->remove($todo, true);
        }

        return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/{id}/complete", name="app_todo_complete", methods={"GET"})
     */
    public function complete(Todo $todo, TodoRepository $todoRepository): Response
    {
        // Met à jour l'état de la tâche
        $todo->setEtat('termine');

        // Utilise ta méthode `completeState` du repository
        $todoRepository->completeState($todo, true); // Passer `true` pour appeler `flush`

        return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/{id}/delete", name="app_todo_delete2", methods={"GET"})
     */
    public function delete2( Todo $todo, TodoRepository $todoRepository): Response
    {
       
            $todoRepository->remove($todo, true);
        

        return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
    }
}
