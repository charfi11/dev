<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\Category;
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

    public function category(Category $c, ThemeRepository $tr, Request $r)
    {
 
        $t = $tr->findAll();
        $l = $c->getLinks();

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

        return $this->render('base/index.html.twig', [
            'theme' => $t,
            'category' => $c,
            'link' => $l
        ]);
     }
}
