<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Theme;
use App\Entity\Astuce;
use App\Data\Search;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\Question;
use App\Form\AstuceType;
use App\Form\CommentType;
use App\Form\QuestionType;
use App\Form\SearchType;
use App\Repository\ThemeRepository;
use App\Repository\AstuceRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function index(ThemeRepository $tr, Request $r, CategoryRepository $crp, AstuceRepository $ar)
    {

        $t = $tr->findAll();
        $c = $crp->findAll();
        $astuces = $ar->findAll();
        
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
            'category' => $c,
            'astuce' => $astuces,
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     */

    public function category($id, AstuceRepository $ar, CategoryRepository $cr, ThemeRepository $tr, Request $r)
    {
 
        $user = $this->getUser();
        $t = $tr->findAll();
        $c = $cr->find($id);
        $l = $c->getLinks();
        $ast = $c->getAst();
        $qs = $c->getQuestions(); 

        $search = new Search();
        $formSearch = $this->createForm(SearchType::class, $search);
        $formSearch->handleRequest($r);

        $filtreAstuce = $ar->findSearch($search, $id, $r);

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

        $q = new Question();
        $formQ = $this->createForm(QuestionType::class, $q);
        $formQ->handleRequest($r);

        if ($formQ->isSubmitted() && $formQ->isValid()) {

            $q->setUser($user);
            $q->setCategori($c);

            $data = $formQ->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
    
            return $this->redirectToRoute('category', ['id' => $c->getId()]);
        }

        return $this->render('base/index.html.twig', [
            'theme' => $t,
            'category' => $c,
            'link' => $l,
            'astuce' => $filtreAstuce,
            'question' => $qs,
            'user' => $user,
            'formAs' => $formAs->createView(),
            'formQ' => $formQ->createView(),
            'formsearch' => $formSearch->createView()
        ]);
     }

     /**
      * @Route("/category/{id}/deleteastuce", name="delete_a")
      */

      public function delete_astuce($id, CategoryRepository $cr, AstuceRepository $ar, Request $rq){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

        $c = $cr->find($id);
        $id_a = $rq->query->get('id');
        $as = $ar->find($id_a);

        $entityManager->remove($as);

        $entityManager->flush();

        return new JsonResponse();

      }
}
