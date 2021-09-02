<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{

  /**
   * @Route("/categorie_afficher/afficher", name="categorie_afficher")
   */
  public function categorie_afficher(CategorieRepository $repoCategorie): Response
  {
    $categoriesArray = $repoCategorie->findAll();
    return $this->render('categorie/categorie_afficher.html.twig', [
      "categories" => $categoriesArray
    ]);
  }


  /**
   * @Route("/categorie/categorie/ajouter", name="categorie_ajouter")
   */
  public function categorie_ajouter(Request $request, EntityManagerInterface $manager): Response
  {
    $categorie = new Categorie;
    $form = $this->createForm(CategorieType::class, $categorie);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $manager->persist($categorie);
      $manager->flush();

      $this->addFlash("success", "La catégorie " . $categorie->getId() . " a bien été ajouté");


      return $this->redirectToRoute("categorie_afficher");
    }

    return $this->render('categorie/categorie_ajouter.html.twig', [
      "formCategorie" => $form->createView()
    ]);
  }


  /**
   * @Route("/categorie/categorie/modifier/{id<\d+>}", name="categorie_modifier")
   */
  public function categorie_modifier(Categorie $categorie, Request $request, EntityManagerInterface $manager): Response
  {
    if (!$categorie) {
      $categorie = new Categorie;
    }

    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $modif = $categorie->getId() !== null;
      $manager->persist($categorie);
      $manager->flush();

      $this->addFlash("success", ($modif) ? "La catégorie " . $categorie->getId() . " a bien été modifiée" : "La catégorie " . $categorie->getId() . " a bien été ajoutée");



      return $this->redirectToRoute('categorie_afficher');
    }

    return $this->render('categorie/categorie_modifier.html.twig', [
      "categorie" => $categorie,
      "formCategorie" => $form->createView(),
      "modification" => $categorie->getId() !== null
    ]);
  }

  /**
   * @Route("/categorie/supprimer/{id}", name="categorie_supprimer")
   */
  public function categorie_supprimer(Categorie $categorie, EntityManagerInterface $manager): Response
  {
    $idCategorie = $categorie->getId();
    $manager->remove($categorie);
    $manager->flush();

    $this->addFlash("success", "La catégorie $idCategorie a bien été supprimée");

    return $this->redirectToRoute('categorie_afficher');


    return $this->render('/categorie/categorie_supprimer.html.twig', []);
  }
}
