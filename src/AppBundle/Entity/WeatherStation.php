<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeatherStation
 *
 * @ORM\Table(name="weather_station")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WeatherStationRepository")
 */
class WeatherStation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="weatherStations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\WeatherStationData", mappedBy="weatherStation", cascade={"remove", "persist"})
     */
    private $weatherStationDatas;

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
     * Set name
     *
     * @param string $name
     *
     * @return WeatherStation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return WeatherStation
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return mixed
     */
    public function getWeatherStationDatas()
    {
        return $this->weatherStationDatas;
    }

    /**
     * @param mixed $weatherStationDatas
     */
    public function setWeatherStationDatas($weatherStationDatas)
    {
        $this->weatherStationDatas = $weatherStationDatas;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getPin(){
        return $this->getId();
    }
}

