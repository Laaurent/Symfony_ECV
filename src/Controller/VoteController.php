<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Recipe;
use App\Form\VoteType;
use App\Repository\VoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vote')]
class VoteController extends AbstractController
{
    #[Route('/', name: 'vote_index', methods: ['GET'])]
    public function index(VoteRepository $voteRepository): Response
    {
        return $this->render('vote/index.html.twig', [
            'votes' => $voteRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'vote_new', methods: ['GET', 'POST'])]
    public function new(Request $request, $id): Response
    {


        $recipe = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->find($id);

        /* dd($this->getUser()->getVotes()); */

        $vote = new Vote();
        $vote->setRecipe($recipe);
        $vote->setUser($this->getUser());

        $recipe->addRating();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($vote);
        $entityManager->persist($recipe);
        $entityManager->flush();


        return $this->redirectToRoute('recipe_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'vote_show', methods: ['GET'])]
    public function show(Vote $vote): Response
    {
        return $this->render('vote/show.html.twig', [
            'vote' => $vote,
        ]);
    }

    #[Route('/{id}/edit', name: 'vote_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vote $vote): Response
    {
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vote/edit.html.twig', [
            'vote' => $vote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'vote_delete', methods: ['POST'])]
    public function delete(Request $request, Vote $vote): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vote->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vote_index', [], Response::HTTP_SEE_OTHER);
    }
}
