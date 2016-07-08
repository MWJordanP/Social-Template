<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Publication;
use AppBundle\Entity\User;
use AppBundle\Form\PublicationType;
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
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('AppBundle:Publication')->findByUser($user);
        $publication = new Publication();

        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $publication->setUser($user);
            $em->persist($publication);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage_connect_profile'));
        }

        return $this->render('app/profile/index.html.twig', [
            'form' => $form->createView(),
            'publications' => $publications,
        ]);
    }

    /**
     * @Route("/profil/{id}", options = { "expose" = true }, name="homepage_connect_profile_show")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(User $user, Request $request)
    {
        $userInProgress = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('AppBundle:Publication')->findByUser($user);
        $likeUserInProgress = $em->getRepository('AppBundle:Social')->findOneBy(['user' => $userInProgress, 'userSocial' => $user]);

        return $this->render('app/profile/show.html.twig', [
            'publications' => $publications,
            'user' => $user,
            'likeUserInProgress' => $likeUserInProgress,
        ]);
    }
}
