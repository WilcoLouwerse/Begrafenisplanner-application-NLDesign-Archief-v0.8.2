<?php

// src/Controller/DashboardController.php

namespace App\Controller;

use App\Service\ApplicationService;
//use App\Service\RequestService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use DateTimeZone;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\CommonGroundService;

/**
 * Class DeveloperController
 * @package App\Controller
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
	 * @Route("/")
	 * @Template
	 */
    public function indexAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = $applicationService->getVariables();

        /**
        //Delete Example:
        $x = [];
        $commonGroundService->deleteResource($x, $commonGroundService->getComponent('grc')['href'].'/cemeteries/ab730cf2-4407-4ceb-91a0-939114d8a3af');
         */

        /**
        //Add Example
        $variables['calendars'] = $commonGroundService->getResourceList($commonGroundService->getComponent('arc')['href'].'/calendars')['hydra:member'];

        $event = [];
        $event['name'] = "TestEvent";
        $event['description'] = "First test event for the HTA script-kiddies mission";
        $event['startDate'] = "2020-04-15 11:48:43";
        $event['endDate'] = "2020-04-15 11:48:43";
        $event['calendar'] = $variables['calendars'][2]['@id'];

        $commonGroundService->createResource($event, $commonGroundService->getComponent('arc')['href'].'/events');
         */

        return $variables;
    }

}






