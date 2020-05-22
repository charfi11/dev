<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Astuce;
use App\Repository\VoteRepository;
use App\Repository\AstuceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoteController extends AbstractController
{

    /**
     * @Route("vote/{id}", name="vote")
     */

     public function Vote(Astuce $as, VoteRepository $ar, Request $r)
     {

       $user = $this->getUser();
       
       if($as->isLikeByUser($user)){
           $vote = $ar->findOneBy([
               'astuces' => $as,
               'user' => $user
           ]);

           $entityManager = $this->getDoctrine()->getManager();

           $entityManager->remove($vote);
           $entityManager->flush();   

           return new JsonResponse(['like' => $ar->count(['astuces' => $as])]);

       }

        $like = new Vote();

        $like->setUser($user);
        $like->setAstuces($as);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();  
        
        $count = $ar->count(['astuces' => $as]);
    
       return new JsonResponse(['like' => $count]);

     }
}
