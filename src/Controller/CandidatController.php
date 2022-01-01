<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/candidat")
 */
class CandidatController extends AbstractController
{
  /**
   * @Route("/user", name="candidat_afficher", methods={"GET"})
   */
  public function candidat(CandidatRepository $candidatRepository): Response
  {
    return $this->render('candidat/candidat_afficher.html.twig', [
      'candidats' => $candidatRepository->findAll(),
    ]);
  }
    /**
   * @Route("/candidat/candidat/ajouter", name="candidat_ajouter")
   */
  public function categorie_ajouter(Request $request, EntityManagerInterface $manager): Response
  {
    $candidat = new Candidat;
    $form = $this->createForm(CandidatType::class, $candidat);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $manager->persist($candidat);
      $manager->flush();

      $this->addFlash("success", "Le candidat " . $candidat->getId() . " a bien été inscrit");


      return $this->redirectToRoute("candidat_afficher");
    }

    return $this->render('candidat/candidat_ajouter.html.twig', [
      "formCandidat" => $form->createView()
    ]);
  }

}