<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Publication;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/social/comment")
 * Class ProfileController
 *
 * @package AppBundle\Controller
 */
class CommentController extends Controller
{
    /**
     * @Route("/{id}", name="comment_form")
     * @param Publication $id
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Publication $publication, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
        }
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment, ['action' => $this->generateUrl('comment_form'), 'method' => 'POST']);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $comment->setUser($user);
            $comment->setUser($publication);
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage_connect_profile'));
        }

        $response = new JsonResponse(
            array(
                'message' => 'Error',
                'form' => $this->renderView('app/comment/form.html.twig',
                    array(
                        'entity' => $comment,
                        'form' => $form->createView(),
                    ))), 400);

        return $response;
    }
}
