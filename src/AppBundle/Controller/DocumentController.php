<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller {

    public function propositionAction()
    {
        return $this->render('AppBundle:Document:proposition.html.twig');
    }

    public function resultatsRechercheAction()
    {
        return new Response('En construction...');
    }


    public function acquisitionConnaissancesAction()
    {
        return new Response('En construction...');
    }

    public function bibliographieAction()
    {
        return new Response('En construction...');
    }

    public function conclusionBilanAction()
    {
        return new Response('En construction...');
    }

    public function demarcheExperimentaleAction()
    {
        return $this->render('@App/Document/demarche_experimentale.html.twig');
    }

    public function difficultesAction()
    {
        return new Response('En construction...');
    }

}