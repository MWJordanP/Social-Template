<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Social;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @Route("/like")
 * Class ProfileController
 *
 * @package AppBundle\Controller
 */
class SocialController extends Controller
{
    /**
     * @Route("/{id}", name="like_profile")
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(User $userLike, Request $request)
    {
        $user = $this->getUser();
        if ($user === $userLike) {
            throw new HttpException('user identitque');
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $checkNotLike = $em->getRepository('AppBundle:Social')->findOneBy(['user' => $user, 'userSocial' => $userLike]);
        if ($checkNotLike === null) {
            $social = new Social();
            $social
                ->setUser($user)
                ->setUserSocial($userLike);
            $em->persist($social);
            $em->flush();
        } else {
            $em->remove($checkNotLike);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('homepage_connect_profile_show', ['id' => $userLike->getId()]));

    }
}
