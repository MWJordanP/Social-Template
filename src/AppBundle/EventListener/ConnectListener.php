<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class ConnectListener implements EventSubscriberInterface
{
    private $router;
    private $tokenStorage;
    private $auth;

    public function __construct(RouterInterface $router, TokenStorageInterface $tokenStorage, AuthorizationChecker $authorizationChecker)
    {
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
        $this->auth = $authorizationChecker;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'onKernelRequest',
        );
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($event->isMasterRequest() && $request->getPathInfo() === '/') {
            /** @var User $user */
            $user = $this->tokenStorage->getToken()->getUser();

            if (!$request->isXmlHttpRequest() && $user instanceof User && $this->auth->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                return $event->setResponse(new RedirectResponse($this->router->generate('homepage_connect_profile')));
            }
        }
    }
}