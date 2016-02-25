<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
