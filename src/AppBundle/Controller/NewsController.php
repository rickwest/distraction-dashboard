<?php

namespace AppBundle\Controller;

use AppBundle\Services\ServiceFactory;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    /**
     * @Route("/api/news/{service}", name="api_service")
     */
    public function showAction(Request $request, $service)
    {
        $serviceFactory = new ServiceFactory(new Client());
        return $this->json($serviceFactory->get($service));
        return $this->json($service);
    }
}
