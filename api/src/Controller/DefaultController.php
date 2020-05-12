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
        $commonGroundService->deleteResource($x, $commonGroundService->getComponent('wrc')['href'].'/organizations/6b131895-6ef6-44db-bb0a-d67070353b03');
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

        //example data to dump on screen
        $variables['ptc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('ptc')['href'].'/stages')['hydra:member'][1];
        $variables['vtc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('vtc')['href'].'/request_types')['hydra:member'][1];
        $variables['vrc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('vrc')['href'].'/requests')['hydra:member'][1];

        //organization for request, request_type, etc.
        $organization = $commonGroundService->getResourceList($commonGroundService->getComponent('wrc')['href'].'/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384')['@id'];

        //brp ingeschreven persoon for submitter
        $ingeschrevenpersoon = $commonGroundService->getResourceList($commonGroundService->getComponent('brp')['href'].'/ingeschrevenpersonen')[0]['@id'];

        //sections (ptc)
 //?       $sections = [];

        //stages (ptc)
 //?       $stages = [];
        $begraafplaatsSection = [];
        $begraafplaatsSection['name'] = "Begraafplaats";
        $begraafplaatsSection['description'] = "Wat is de begraafplaats en het graf type voor de begrafenis";
        $begraafplaatsSection['icon'] = "fa fa-headstone";
        $begraafplaatsSection['slug'] = "begraafplaats";
        $begraafplaatsSection['start'] = true;
        $begraafplaatsSection['next'] = "url volgende stap";

 //!       $process_type = $commonGroundService->createResource($process_type, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //properties (vtc)
        $properties = [];

        //request_type (vtc)
        $request_type = [];
        $request_type['organization'] = $organization;
        $request_type['icon'] = "fa fa-headstone";
        $request_type['name'] = "Begrafenis plannen";
        $request_type['description'] = "Met dit verzoek kunt u een begrafenis plannen";
        $request_type['properties'] = $properties;

 //!       $request_type = $commonGroundService->createResource($request_type, $commonGroundService->getComponent('vtc')['href'].'/request_types');

        //process_type (ptc)
        $process_type = [];
        $process_type['name'] = "Begrafenis plannen";
        $process_type['description'] = "Plan een begrafenis op een gekozen begraafplaats";
        $process_type['icon'] = "fa fa-headstone";
        $process_type['sourceOrganization'] = "0000";
 //!       $process_type['requestType'] = $request_type['@id'];

 //!       $process_type = $commonGroundService->createResource($process_type, $commonGroundService->getComponent('ptc')['href'].'/process_types');

        //submitter (vrc)
        $submitter = [];
        $submitter['brp'] = $ingeschrevenpersoon;
 //!       $submitter = $commonGroundService->createResource($submitter, $commonGroundService->getComponent('vrc')['href'].'/submitters');

        //request (vrc)
        $request = [];
        $request['organization'] = $organization;
        $request['reference'] = "Testbegrafenis 2020-5";
        $request['status'] = "incomplete";
 //!       $request['requestType'] = $request_type['@id'];
 //!       $request['processType'] = $process_type['@id'];
        $request['properties'] = $properties;
        $request['currentStage'] = "Begraafplaats";
        $request['submitters'] = $submitter;

 //!       $commonGroundService->createResource($request, $commonGroundService->getComponent('vrc')['href'].'/requests');

        return $variables;
    }

}






