<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/search")
 * Class ProfileController
 *
 * @package AppBundle\Controller
 */
class SearchController extends Controller
{
    /**
     * @Route("/", name="search_user")
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $names = array();
        $term = trim(strip_tags($request->get('term')));
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findLikeUsername($term);
        foreach ($users as $user)
        {
            /** @var User $user */
            $names[] = ['id' => $user->getId(), 'username' => $user->getUsername()];
        }

        $response = new JsonResponse();
        $response->setData($names);

        return $response;
    }
}
