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
        return $this->render('AppBundle:Document:resultatsRecherche.html.twig');
    }


    public function acquisitionConnaissancesAction()
    {
        return $this->render('AppBundle:Document:acquisition.html.twig');
    }

    public function bibliographieAction()
    {
        return $this->render('AppBundle:Document:bibliographie.html.twig');
    }

    public function conclusionBilanAction()
    {
        return $this->render('AppBundle:Document:conclusion.html.twig');
    }

    public function demarcheExperimentaleAction()
    {
        return $this->render('@App/Document/demarche_experimentale.html.twig');
    }

    public function difficultesAction()
    {
        return $this->render('AppBundle:Document:difficultes.html.twig');
    }

}