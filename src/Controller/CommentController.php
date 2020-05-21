<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ThemeRepository;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{id}", name="comment")
     */
    public function comment($id, CategoryRepository $crp, ThemeRepository $tr, QuestionRepository $qr, Request $r)
    {

        $user = $this->getUser();
        $t = $tr->findAll();
        $c = $crp->findAll();
        $q = $qr->find($id);
        
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

        $comment = new Comment();
        $formC = $this->createForm(CommentType::class, $comment);
        $formC->handleRequest($r);

        if ($formC->isSubmitted() && $formC->isValid()) {

            $comment->setUser($user);
            $comment->setQst($q);

            $data = $formC->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
    
            return $this->redirectToRoute('comment', ['id' => $q->getId()]);

        }

        return $this->render('comment/index.html.twig', [
            'theme' => $t,
            'category' => $c,
            'question' => $q,
            'formc' => $formC->createview()
        ]);
    }
}
