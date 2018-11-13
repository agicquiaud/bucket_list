<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends Controller
{
    /**
     * @Route("/detail/{id}", name="wish_detail")
     * @param $wish
     */
    public function detail(Wish $wish){
        return $this->render("wish/detail.html.twig", [
            "wish" => $wish
        ]);
    }

    /**
     * @Route("/remove/{id}", name="wish_remove")
     * @param $wish
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove(Wish $wish){
        $em = $this->getDoctrine()->getManager();
        $em->remove($wish);
        $em->flush();
        $this->addFlash("success", "L'idée à bien été supprimée !");
        return $this->redirectToRoute("home");
    }
    /**
     * @Route("/idea/create", name="wish_create")
     */
    public function create(Request $request){
        //Créer l'objet wish
        $wish = new Wish();
        //
        $form = $this->createForm(WishType::class, $wish);
        //
        $form->handleRequest($request);
        //si le formulaire est valide ...
        if ($form->isSubmitted() && $form->isValid()){
            //Renseigne les champs manquant
            $wish->setDateCreated(new \DateTime());
            //sauvegarde
            $em = $this->getDoctrine()->getManager();
            $em->persist($wish);
            $em->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render("wish/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/update/{id}", name="wish_update")
     */
    public function update(Wish $wish, Request $request){
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $wish->setDateUpdate(new \DateTime());
            $em=$this->getDoctrine()->getManager();
            $em->persist($wish);
            $em->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render("wish/update.html.twig", [
            "form"=>$form->createView()
        ]);
    }
}
