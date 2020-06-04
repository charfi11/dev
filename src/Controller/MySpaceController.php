<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MySpaceController extends AbstractController
{
    /**
     * @Route("/space", name="space")
     */
    public function index()
    {
        return $this->render('my_space/index.html.twig', [

        ]);
    }

     /**
     * @Route("/space/{id}", name="my_space")
     */
    public function spaceUser($id, UserRepository $ur)
    {

        $u = $ur->find($id);

        dump($u);

        return $this->render('my_space/index.html.twig', [
            'user' => $u
        ]);
    }
}
