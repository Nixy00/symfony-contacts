<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class HelloController extends AbstractController
{


    #[Route('/hello/{name}/{times}', name: 'app_hello_manyTimes', requirements: ['times' => Requirement::DIGITS])]
    public function manyTimes(string $name, int $times = 3): Response
    {
        if ($times == 0 or $times >= 10) {
            return $this->redirectToRoute('app_hello_manyTimes', ['name' => $name, 'times' => 3]);
        }

        return $this->render('hello/many_times.html.twig', ['name' => $name, 'times' => $times]);
    }

    #[Route('/hello/{name}')]
    public function world(string $name): Response
    {
        return $this->render('hello/world.html.twig', ['name' => $name]);
    }

    #[Route('/hello', name: 'app_hello')]
    public function index(): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
        ]);
    }
}
