<?php
namespace App\Controller;

use App\Entity\Wish;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class MainController extends Controller
{
    /**
     * @Route("/fr/home", name="home")
     */
    public  function home()
    {
        $wishRepository = $this->getDoctrine()->getRepository(Wish::class);
        $wishes = $wishRepository->findBy([], ["dateCreated"=>"DESC", "label"=>"DESC"], 5, 0);
        $wishesCount = $wishRepository->count([]);
        //cherche dans le dossier template
        return $this->render("main/home.html.twig", [
            "wishes" => $wishes,
            "wishesCount" => $wishesCount
        ]);
        //return new Response("hello world");
        //return $this->redirect("http://google.fr/");
    }
    /**
     * @Route("FAQ", name="faq")
     */
    public  function faq()
    {
        return $this->render("main/faq.html.twig");
    }
    /**
     * @Route("contact", name="contact")
     */
    public function contact(){
        return $this->render("main/contact.html.twig");
    }
    /**
     * @Route("CGU", name="cgu")
     */
    public function cgu(){
        return $this->render("main/cgu.html.twig");
    }
}