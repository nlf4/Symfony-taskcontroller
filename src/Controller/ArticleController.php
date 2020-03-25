<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
public function homepage()
{
    return new Response('WELCOME');
}


    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        $comments = [
            'I ate a rock once.'
        ];
        return $this->render('article/show.html.twig', ['title' => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
            ]);
    }
}