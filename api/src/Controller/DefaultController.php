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

        //example data to dump on screen
        //$variables['ptc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('ptc')['href'].'/sections')['hydra:member'][1];
        //$variables['vtc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('vtc')['href'].'/properties')['hydra:member'][1];
        //$variables['vrc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('vrc')['href'].'/requests')['hydra:member'][1]['properties'];

        //organization for request, request_type, etc.
        $organization = $commonGroundService->getResourceList($commonGroundService->getComponent('wrc')['href'].'/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384')['@id'];

        //properties (vtc)
        //gemeente property
        $gemeenteProperty = [];
        $gemeenteProperty['title'] = "Gemeente";
        $gemeenteProperty['name'] = "gemeente";
        $gemeenteProperty['type'] = "string";
        $gemeenteProperty['format'] = "string";
        $gemeenteProperty['iri'] = "wrc/organizations";
        $gemeenteProperty['required'] = true;
        //$gemeenteProperty = $commonGroundService->createResource($gemeenteProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //begraafplaats property
        $begraafplaatsProperty = [];
        $begraafplaatsProperty['title'] = "Begraafplaats";
        $begraafplaatsProperty['name'] = "begraafplaats";
        $begraafplaatsProperty['type'] = "string";
        $begraafplaatsProperty['format'] = "string";
        $begraafplaatsProperty['iri'] = "grc/cemeteries";
        $begraafplaatsProperty['required'] = true;
        //$begraafplaatsProperty = $commonGroundService->createResource($begraafplaatsProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //grafsoort property
        $grafsoortProperty = [];
        $grafsoortProperty['title'] = "Soort Graf";
        $grafsoortProperty['name'] = "grafsoort";
        $grafsoortProperty['type'] = "string";
        $grafsoortProperty['format'] = "string";
        $grafsoortProperty['iri'] = "grc/grave_types";
        $grafsoortProperty['required'] = true;
        //$grafsoortProperty = $commonGroundService->createResource($grafsoortProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //event property
        $eventProperty = [];
        $eventProperty['title'] = "Event";
        $eventProperty['name'] = "event";
        $eventProperty['type'] = "string";
        $eventProperty['format'] = "string";
        $eventProperty['iri'] = "arc/events";
        $eventProperty['required'] = true;
        //$eventProperty = $commonGroundService->createResource($eventProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //artikelen property
        $artikelenProperty = [];
        $artikelenProperty['title'] = "Artikelen";
        $artikelenProperty['name'] = "artikelen";
        $artikelenProperty['type'] = "string";
        $artikelenProperty['format'] = "string";
        $artikelenProperty['required'] = false;
        //$artikelenProperty = $commonGroundService->createResource($artikelenProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //overledene property
        $overledeneProperty = [];
        $overledeneProperty['title'] = "Overledene";
        $overledeneProperty['name'] = "overledene";
        $overledeneProperty['type'] = "string";
        $overledeneProperty['format'] = "string";
        $overledeneProperty['iri'] = "brp/ingeschrevenpersonen";
        $overledeneProperty['required'] = true;
        //$overledeneProperty = $commonGroundService->createResource($enddatumtijdProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //belanghebbende property
        $belanghebbendeProperty = [];
        $belanghebbendeProperty['title'] = "Belanghebbende";
        $belanghebbendeProperty['name'] = "belanghebbende";
        $belanghebbendeProperty['type'] = "string";
        $belanghebbendeProperty['format'] = "string";
        $belanghebbendeProperty['iri'] = "brp/ingeschrevenpersonen";
        $belanghebbendeProperty['required'] = true;
        //$belanghebbendeProperty = $commonGroundService->createResource($belanghebbendeProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //sections (ptc)
        //Gemeente section voor begraafplaats stage
        $gemeenteSection = [];
        $gemeenteSection['name'] = "Gemeente section";
        $gemeenteSection['description'] = "This is the section where the user can select a Gemeente";
        $gemeenteSection['properties'] = $gemeenteProperty;
        //$gemeenteSection = $commonGroundService->createResource($gemeenteSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Begraafplaats section voor begraafplaats stage
        $begraafplaatsSection = [];
        $begraafplaatsSection['name'] = "Begraafplaats section";
        $begraafplaatsSection['description'] = "This is the section where the user can select a Begraafplaats";
        $begraafplaatsSection['properties'] = $begraafplaatsProperty;
        //$begraafplaatsSection = $commonGroundService->createResource($begraafplaatsSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Grafsoort section voor begraafplaats stage
        $grafsoortSection = [];
        $grafsoortSection['name'] = "Grafsoort section";
        $grafsoortSection['description'] = "This is the section where the user can select a Soort Graf";
        $grafsoortSection['properties'] = $grafsoortProperty;
        //$grafsoortSection = $commonGroundService->createResource($grafsoortSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Datumtijd section voor datumtijd stage
        $datumtijdSection = [];
        $datumtijdSection['name'] = "Datum en tijd section";
        $datumtijdSection['description'] = "This is the section where the user can select a start and end Datum en Tijd";
        $datumtijdSection['properties'] = $eventProperty;
        //$datumtijdSection = $commonGroundService->createResource($datumtijdSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Artikelen section voor artikelen stage
        $artikelenSection = [];
        $artikelenSection['name'] = "Artikelen section";
        $artikelenSection['description'] = "This is the section where the user can select Artikelen";
        $artikelenSection['properties'] = $artikelenProperty;
        //$artikelenSection = $commonGroundService->createResource($artikelenSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Overledene section voor overledene stage
        $overledeneSection = [];
        $overledeneSection['name'] = "Overledene section";
        $overledeneSection['description'] = "This is the section where the user can select a Overledene";
        $overledeneSection['properties'] = $overledeneProperty;
        //$overledeneSection = $commonGroundService->createResource($overledeneSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Belanghebbende section voor belanghebbende stage
        $belanghebbendeSection = [];
        $belanghebbendeSection['name'] = "Belanghebbende section";
        $belanghebbendeSection['description'] = "This is the section where the user can select a Belanghebbende";
        $belanghebbendeSection['properties'] = $belanghebbendeProperty;
        //$belanghebbendeSection = $commonGroundService->createResource($belanghebbendeSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //stages (ptc)
        //begraafplaats stage
        $begraafplaatsStage = [];
        $begraafplaatsStage['name'] = "Begraafplaats";
        $begraafplaatsStage['description'] = "Wat is de begraafplaats en het graf type voor het graf";
        $begraafplaatsStage['icon'] = "fa fa-headstone";
        $begraafplaatsStage['slug'] = "begraafplaats";
        $begraafplaatsStageSections = [];
        $begraafplaatsStageSections[0] = $gemeenteSection;
        $begraafplaatsStageSections[1] = $begraafplaatsSection;
        $begraafplaatsStageSections[2] = $grafsoortSection;
        $begraafplaatsStage['sections'] = $begraafplaatsStageSections;
        $begraafplaatsStage['start'] = true;
        //$begraafplaatsStage = $commonGroundService->createResource($begraafplaatsStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //datum en tijd stage
        $datumtijdStage = [];
        $datumtijdStage['name'] = "Datum en Tijd";
        $datumtijdStage['description'] = "Kies een Datum en Tijd waarop de begrafenis zal plaatsvinden";
        $datumtijdStage['icon'] = "fa fa-calendar";
        $datumtijdStage['slug'] = "datumtijd";
        $datumtijdStage['sections'] = $datumtijdSection;
        $datumtijdStage['previous'] = "url begraafplaats stage";
        //$datumtijdStage = $commonGroundService->createResource($datumtijdStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //artikelen stage
        $artikelenStage = [];
        $artikelenStage['name'] = "Artikelen";
        $artikelenStage['description'] = "Selecteer artikelen voor de begrafenis";
        $artikelenStage['icon'] = "fa fa-tasks";
        $artikelenStage['slug'] = "artikelen";
        $datumtijdStage['sections'] = $artikelenSection;
        $artikelenStage['previous'] = "url datumtijd stage";
        //$artikelenStage = $commonGroundService->createResource($artikelenStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //overledene stage
        $overledeneStage = [];
        $overledeneStage['name'] = "Overledene";
        $overledeneStage['description'] = "Selecteer hier de gegevens van de overledene";
        $overledeneStage['icon'] = "fa fa-id-card-o";
        $overledeneStage['slug'] = "overledene";
        $datumtijdStage['sections'] = $overledeneSection;
        $overledeneStage['previous'] = "url artikelen stage";
        //$overledeneStage = $commonGroundService->createResource($overledeneStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //belanghebbende stage
        $belanghebbendeStage = [];
        $belanghebbendeStage['name'] = "Belanghebbende";
        $belanghebbendeStage['description'] = "Selecteer hier de gegevens van de belanghebbende";
        $belanghebbendeStage['icon'] = "fa fa-id-card-o";
        $belanghebbendeStage['slug'] = "belanghebbende";
        $datumtijdStage['sections'] = $belanghebbendeSection;
        $belanghebbendeStage['previous'] = "url overledene stage";
        //$belanghebbendeStage = $commonGroundService->createResource($belanghebbendeStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //properties list for request_type
        $properties = [];
        $properties['gemeente'] = "";
        $properties['begraafplaats'] = "";
        $properties['grafsoort'] = "";
        $properties['event'] = "";
        $properties['artikelen'] = array();
        $properties['overledene'] = "";
        $properties['belanghebbende'] = "";

        //request_type (vtc)
        $request_type = [];
        $request_type['organization'] = $organization;
        $request_type['icon'] = "fa fa-headstone";
        $request_type['name'] = "Begrafenis plannen";
        $request_type['description'] = "Met dit verzoek kunt u een begrafenis plannen";
        $request_type['properties'] = $properties;
        //$request_type = $commonGroundService->createResource($request_type, $commonGroundService->getComponent('vtc')['href'].'/request_types');

        //stages list for process_type
        $stages = [];
        $stages[0] = $begraafplaatsStage;
        $stages[1] = $datumtijdStage;
        $stages[2] = $artikelenStage;
        $stages[3] = $overledeneStage;
        $stages[4] = $belanghebbendeStage;

        //process_type (ptc)
        $process_type = [];
        $process_type['name'] = "Begrafenis plannen";
        $process_type['description'] = "Plan een begrafenis op een gekozen begraafplaats";
        $process_type['icon'] = "fa fa-headstone";
        $process_type['sourceOrganization'] = "00000000";
        $process_type['stages'] = $stages;
        //$process_type['requestType'] = $request_type['@id'];
        //$process_type = $commonGroundService->createResource($process_type, $commonGroundService->getComponent('ptc')['href'].'/process_types');

        //submitter (vrc)
        $submitter = $commonGroundService->getResource($commonGroundService->getComponent('vrc')['href'].'/submitters/b3ebee91-933f-4765-b6bb-0e46664c5d80');
        $resource['submitters'] = [$submitter['@id']];

        //properties list for request
        $properties['gemeente'] = "https://wrc.dev.begraven.zaakonline.nl/organizations/429e66ef-4411-4ddb-8b83-c637b37e88b5";
        $properties['begraafplaats'] = "https://grc.dev.begraven.zaakonline.nl/cemeteries/b38e2efd-6f5a-4bba-b755-50accf15372f";
        $properties['grafsoort'] = "https://grc.dev.begraven.zaakonline.nl/grave_types/429e66ef-4411-4ddb-8b83-c637b37e88b5";
        $properties['event'] = "https://arc.dev.begraven.zaakonline.nl/events/262ee715-3d82-4c15-a2a8-5da2627ccb92";
        $properties['artikelen'] = "Gebruik Orgel, CD";
        $properties['overledene'] = "https://brp.dev.zaakonline.nl/ingeschrevenpersonen/uuid/7142ae0e-594b-4c7a-bdac-c3d183cb2c32";
        $properties['belanghebbende'] = "https://brp.dev.zaakonline.nl/ingeschrevenpersonen/uuid/b48a3aac-eb4d-4de2-b776-df29e7263410";

        //request (vrc)
        $request = [];
        $request['organization'] = $organization;
        $request['reference'] = "Testbegrafenis 2020-5";
        $request['status'] = "incomplete";
        $request['requestType'] = "https://vtc.dev.begraven.zaakonline.nl/request_types/c2e9824e-2566-460f-ab4c-905f20cddb6c";
        $request['processType'] = "https://ptc.dev.begraven.zaakonline.nl/process_types/a8b8ce49-d5db-4270-9e42-4b47902fc817";
        $request['properties'] = $properties;
        $request['currentStage'] = "Begraafplaats";
        $request['submitters'] = $resource['submitters'];
        //$commonGroundService->createResource($request, $commonGroundService->getComponent('vrc')['href'].'/requests');

        return $variables;
    }

}






