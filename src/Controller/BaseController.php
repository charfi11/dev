<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Theme;
use App\Entity\Astuce;
use App\Entity\Category;
use App\Form\AstuceType;
use App\Repository\ThemeRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function index(ThemeRepository $tr, Request $r, CategoryRepository $crp)
    {

        $t = $tr->findAll();
        $c = $crp->findAll();
        
        if($r->isXmlHttpRequest()){

            $rq = $r->query->get('id');
            $rid = $tr->find($rq);
            $c = $rid->getCategories();
            $arr = array();
            foreach($c as $c){
                $id = $c->getId();
                $n = $c->getName();
                $i = $c->getImg();
                $a = array(
                    'id' => $id,
                    'name' => $n,
                    'img' => $i
                );
                $arr[] = $a;
            }

             return new JsonResponse($arr);
        }

        return $this->render('base.html.twig', [
            'theme' => $t,
            'category' => $c
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     */

    public function category($id, CategoryRepository $cr, ThemeRepository $tr, Request $r)
    {
 
        $user = $this->getUser();
        $t = $tr->findAll();
        $c = $cr->find($id);
        $l = $c->getLinks();
        $ast = $c->getAst();

        if($r->isXmlHttpRequest()){

            $rq = $r->query->get('id');
            $rid = $tr->find($rq);
            $c = $rid->getCategories();
            $arr = array();
            foreach($c as $c){
                $id = $c->getId();
                $n = $c->getName();
                $i = $c->getImg();
                $a = array(
                    'id' => $id,
                    'name' => $n,
                    'img' => $i
                );
                $arr[] = $a;
            }

             return new JsonResponse($arr);
        }

        $date = date("Y/m/d");
        dump($c);

        $astuce = new Astuce();
        $formAs = $this->createForm(AstuceType::class, $astuce);
        $formAs->handleRequest($r);

        if ($formAs->isSubmitted() && $formAs->isValid()) {

            $astuce->setUser($user);
            $astuce->setCategoris($c);
            $astuce->setDate($date);

            $data = $formAs->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
    
            return $this->redirectToRoute('category', ['id' => $c->getId()]);
        }

        return $this->render('base/index.html.twig', [
            'theme' => $t,
            'category' => $c,
            'link' => $l,
            'astuce' => $ast,
            'formAs' => $formAs->createView()
        ]);
     }
}
