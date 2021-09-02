<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\Annonce1Type;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonce")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/", name="annonce_afficher", methods={"GET"})
     */
    public function annonce(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/annonce_afficher.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="annonce_ajouter", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(Annonce1Type::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $annonce->setDateEnregistrement(new \DateTimeImmutable('now'));
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/annonce_ajouter.html.twig', [
            'annonce' => $annonce,
            'formAnnonce1' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="annonce_show", methods={"GET"})
     */
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/annonce_show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="annonce_modifier", methods={"GET","POST"})
     */
    public function edit(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(Annonce1Type::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_afficher', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/annonce_modifier.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="annonce_delete", methods={"POST"})
     */
    public function delete(Request $request, Annonce $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_afficher', [], Response::HTTP_SEE_OTHER);
    }
}
