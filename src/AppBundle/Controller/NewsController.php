<?php

namespace AppBundle\Controller;

use AppBundle\Services\Cache\RedisPodcastCache;
use AppBundle\Services\ServiceFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewsController extends Controller
{
    /**
     * @Route("/api/news/{service}", name="api_service")
     * @param string $service
     * @param RedisPodcastCache $cache
     * @return JsonResponse
     */
    public function showAction($service, RedisPodcastCache $cache)
    {
        $serviceFactory = new ServiceFactory($cache->getCache());
        return $this->json($serviceFactory->get($service));
    }
}
