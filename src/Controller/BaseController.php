<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\Category;
use App\Repository\ThemeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function index(ThemeRepository $tr, Request $r)
    {

        $t = $tr->findAll();

        if($r->isXmlHttpRequest()){

            $rq = $r->query->get('id');
            $rid = $tr->find($rq);
            $c = $rid->getCategories();
            $arr = array();
            foreach($c as $c){
                $n = $c->getName();
                $i = $c->getImg();
                $a = array(
                    'name' => $n,
                    'img' => $i
                );
                $arr[] = $a;
            }

             return new JsonResponse($arr);
        }

        return $this->render('base.html.twig', [
            'theme' => $t,
        ]);
    }
}
