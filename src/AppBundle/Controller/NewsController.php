<?php

namespace AppBundle\Controller;

use AppBundle\Services\ServiceFactory;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Simple\RedisCache;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    /**
     * @Route("/api/news/{service}", name="api_service")
     */
    public function showAction(Request $request, $service)
    {
        $redisClient = RedisAdapter::createConnection('redis://127.0.0.1:6379');
        $cache = new RedisCache($redisClient,'',600);
        $serviceFactory = new ServiceFactory(new Client(), $cache);
        return $this->json($serviceFactory->get($service));
    }
}
