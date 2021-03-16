<?php
namespace App\EventListener;
use App\Repository\UserRepository;
use App\Service\RequestGet;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var RequestGet
     */
    private $requestGet;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, RequestGet $requestGet,UserRepository $userRepository)
    {
        $this->requestStack = $requestStack;
        $this->requestGet = $requestGet;
        $this->userRepository = $userRepository;
    }


    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $requestService = $this->requestGet->getRequest($request);
        $payload = $event->getData();
        if(count($payload['roles'])>1 && !isset($requestService['roles']))
        {
            throw new \RuntimeException("Veuillez choisir un profile");
        }
        if(count($payload['roles'])>1 && isset($requestService['roles']))
        {
           // $user = $this->userRepository->findOneBy(['username'=>$payload['username']]);
            foreach ($payload['roles'] as $role)
            {
                if( $role === $requestService['roles'][0])
                {
                    $payload['roles'] =$requestService['roles'];
                    $event->setData($payload);

                }

            }

        }
    }
}