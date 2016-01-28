<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
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
