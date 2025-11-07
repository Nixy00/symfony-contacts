<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HelloController extends AbstractController
{
    #[Route('/hello/{name}', name: 'app_hello_world')]
    public function world(string $name): Response
    {
        return $this->manyTimes($name, 3);
    }

    #[Route('/hello/{name}/{times}', name: 'app_hello_manytimes', requirements: ['times' => '\d+'])]
    public function manyTimes(string $name, int $times): Response
    {
        if ($times < 1 || $times > 10) {
            return $this->redirectToRoute('app_hello_manytimes', ['name' => $name, 'times' => 3]);
        }
        $name = ucfirst(strtolower($name));

        return $this->render('hello/many_times.html.twig', ['name' => $name, 'times' => $times]);
    }

    #[Route('/hello', name: 'app_hello')]
    public function index(): Response
    {
        return $this->render('hello/index.html.twig');
    }
}
