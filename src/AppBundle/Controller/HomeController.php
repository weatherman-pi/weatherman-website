<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function indexAction()
    {
        $weatherDatas = array();


        $weatherStations = $this->getDoctrine()->getRepository('AppBundle:WeatherStation')->getAllWeatherStations();

        foreach ($weatherStations as $weatherStation) {
            $weatherDatas[$weatherStation->getPin()] = $this->getDoctrine()->getRepository('AppBundle:WeatherStationData')->getLatestWeatherDataForPin($weatherStation->getPin());
        }

        return $this->render('AppBundle:Home:index.html.twig', array(
            'weatherStations' => $weatherStations,
            'weatherDatas' => $weatherDatas
        ));
    }

    public function indexUserAction()
    {
        $userWeatherStations = array();
        $userWeatherDatas = array();
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $userID = $this->get('security.token_storage')->getToken()->getUser()->getId();

            $userWeatherStations = $this->getDoctrine()->getRepository('AppBundle:WeatherStation')->getWeatherStationsForUserID($userID);

            foreach ($userWeatherStations as $weatherStation) {
                $userWeatherDatas[$weatherStation->getPin()] = $this->getDoctrine()->getRepository('AppBundle:WeatherStationData')->getLatestWeatherDataForPin($weatherStation->getPin());
            }
        }

        return $this->render('AppBundle:Home:index.html.twig', array(
            'weatherStations' => $userWeatherStations,
            'weatherDatas' => $userWeatherDatas
        ));
    }

    public function propositionAction()
    {
        return new Response('En construction...');
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
        return new Response('En construction...');
    }

    public function difficultesAction()
    {
        return new Response('En construction...');
    }
}
