<?php

namespace App\Controller;

use App\Entity\Magasin;
use App\Form\MagasinType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MagasinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @Route("/admin")
 */

class MagasinController extends AbstractController
{
     /**
   * @Route("/magasin_afficher/afficher", name="magasin_afficher")
   */

    public function magasin_afficher(MagasinRepository $repoMagasin): Response
    {
        $magasinsArray = $repoMagasin->findAll();
        return $this->render('magasin/magasin_afficher.html.twig', [
        "magasins" => $magasinsArray
        ]);
    }

      /**
   * @Route("/magasin/magasin/ajouter", name="magasin_ajouter")
   */
  public function magasin_ajouter(Request $request, EntityManagerInterface $manager): Response
  {
    $magasin = new Magasin;
    $form = $this->createForm(MagasinType::class, $magasin);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $manager->persist($magasin);
      $manager->flush();

      $this->addFlash("success", "Le magasin " . $magasin->getId() . " a bien été ajouté");


      return $this->redirectToRoute("magasin_afficher");
    }

    return $this->render('magasin/magasin_ajouter.html.twig', [
      "formMagasin" => $form->createView()
    ]);
  }

   /**
   * @Route("/magasin/modifier/modifier/{id<\d+>}", name="magasin_modifier")
   */
  public function magasin_modifier(Magasin $magasin, Request $request, EntityManagerInterface $manager): Response
  {
    if (!$magasin) {
      $magasin = new Magasin;
    }

    $form = $this->createForm(MagasinType::class, $magasin);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $modif = $magasin->getId() !== null;
      $manager->persist($magasin);
      $manager->flush();

      $this->addFlash("success", ($modif) ? "Le magin " . $magasin->getId() . " a bien été modifiée" : "Le magasin " . $magasin->getId() . " a bien été ajoutée");



      return $this->redirectToRoute('magasin_afficher');
    }

    return $this->render('magasin/magasin_modifier.html.twig', [
      "magasin" => $magasin,
      "formMagasin" => $form->createView(),
      "modification" => $magasin->getId() !== null
    ]);
  }


  /**
   * @Route("/magasin/supprimer/{id}", name="magasin_supprimer")
   */
  public function magasin_supprimer(Magasin $magasin, EntityManagerInterface $manager): Response
  {
    $idMagasin = $magasin->getId();
    $manager->remove($magasin);
    $manager->flush();

    $this->addFlash("success", "Le magasin $idMagasin a bien été supprimée");

    return $this->redirectToRoute('magasin_afficher');


    return $this->render('/magasin/magasin_supprimer.html.twig', []);
  }



}
