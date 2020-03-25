<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/")
     */
public function homepage()
{
    return new Response('WELCOME');
}

    /**
     * @Route("/news/ba-jeebajoop")
     */
    public function show()
    {
        return new Response('future page');
    }
}