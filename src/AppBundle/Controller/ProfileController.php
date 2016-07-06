<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/social")
 * Class ProfileController
 *
 * @package AppBundle\Controller
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="homepage_connect_profile")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        return $this->render('app/profile/index.html.twig');
    }
}
