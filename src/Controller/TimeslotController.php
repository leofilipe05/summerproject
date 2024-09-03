<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TimeslotController extends AbstractController
{
    #[Route('/timeslot', name: 'app_timeslot')]
    public function index(): Response
    {
        return $this->render('timeslot/index.html.twig', [
            'controller_name' => 'TimeslotController',
        ]);
    }
}
