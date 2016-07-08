<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Publication;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Route("/{id}", name="comment_new")
     * @param Publication $publication
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Publication $publication, Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('AppBundle:Comment')->findByPublication($publication);
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($request->isMethod('POST') && $form->isValid()) {
            $comment->setUser($user);
            $comment->setPublication($publication);
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('comment_new', ['id' => $publication->getId()]));
        }

        return $this->render('app/comment/form.html.twig', [
            'form' => $form->createView(),
            'publication' => $publication,
            'comments' => $comments,
        ]);
    }
}
