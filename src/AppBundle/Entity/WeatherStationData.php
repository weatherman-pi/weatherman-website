<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeatherStationData
 *
 * @ORM\Table(name="weather_station_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WeatherStationDataRepository")
 */
class WeatherStationData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="pressure", type="float")
     */
    private $pressure;

    /**
     * @var float
     *
     * @ORM\Column(name="temperature", type="float")
     */
    private $temperature;

    /**
     * @var float
     *
     * @ORM\Column(name="humidity", type="float")
     */
    private $humidity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetime")
     */
    private $updateTime;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\WeatherStation", inversedBy="weatherStationDatas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $weatherStation;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pressure
     *
     * @param float $pressure
     *
     * @return WeatherStationData
     */
    public function setPressure($pressure)
    {
        $this->pressure = $pressure;

        return $this;
    }

    /**
     * Get pressure
     *
     * @return float
     */
    public function getPressure()
    {
        return $this->pressure;
    }

    /**
     * Set temperature
     *
     * @param float $temperature
     *
     * @return WeatherStationData
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return float
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set humidity
     *
     * @param float $humidity
     *
     * @return WeatherStationData
     */
    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;

        return $this;
    }

    /**
     * Get humidity
     *
     * @return float
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * @param mixed $updateTime
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @return mixed
     */
    public function getWeatherStation()
    {
        return $this->weatherStation;
    }

    /**
     * @param mixed $weatherStation
     */
    public function setWeatherStation($weatherStation)
    {
        $this->weatherStation = $weatherStation;
    }
}

