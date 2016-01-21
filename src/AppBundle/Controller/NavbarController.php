<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavbarController extends Controller
{
    public function topbarAction()
    {
        return $this->render('@App/Navbar/topbar.html.twig');
    }
}
