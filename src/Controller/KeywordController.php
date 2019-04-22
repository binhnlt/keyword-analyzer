<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class KeywordController extends AbstractController
{
    /**
     * Display report base on keywords
     * 
     * @Route("/keyword/report", name="keyword_report")
     */
    public function indexAction()
    {
        return $this->render('keyword/index.html.twig', [
            'controller_name' => 'KeywordController',
        ]);
    }

    /**
     * Display the form that allow user to upload CSV file
     * 
     * @Route("/keyword/upload", name="keyword_upload")
     */
    public function uploadAction()
    {
        return $this->render('keyword/upload.html.twig', [
        ]);
    }
}
