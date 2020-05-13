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
        $variables['ptc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('ptc')['href'].'/sections')['hydra:member'][1];
        $variables['vtc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('vtc')['href'].'/properties')['hydra:member'][1];
        $variables['vrc'] = $commonGroundService->getResourceList($commonGroundService->getComponent('vrc')['href'].'/requests')['hydra:member'][1]['properties'];

        //organization for request, request_type, etc.
        $organization = $commonGroundService->getResourceList($commonGroundService->getComponent('wrc')['href'].'/organizations/d736013f-ad6d-4885-b816-ce72ac3e1384')['@id'];

        //brp ingeschreven persoon for submitter, overledene and belanghebbende
        $ingeschrevenpersoon1 = $commonGroundService->getResourceList($commonGroundService->getComponent('brp')['href'].'/ingeschrevenpersonen')[0]['@id'];
        $ingeschrevenpersoon2 = $commonGroundService->getResourceList($commonGroundService->getComponent('brp')['href'].'/ingeschrevenpersonen')[1]['@id'];
        $ingeschrevenpersoon3 = $commonGroundService->getResourceList($commonGroundService->getComponent('brp')['href'].'/ingeschrevenpersonen')[2]['@id'];

        //properties (vtc)
        //gemeente property
        $gemeenteProperty = [];
        $gemeenteProperty['title'] = "Gemeente";
        $gemeenteProperty['name'] = "gemeente";
        $gemeenteProperty['type'] = "string";
        $gemeenteProperty['format'] = "string";
 //?       $gemeenteProperty['iri'] = "";
        $gemeenteProperty['required'] = true;
 //!       $gemeenteProperty = $commonGroundService->createResource($gemeenteProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //begraafplaats property
        $begraafplaatsProperty = [];
        $begraafplaatsProperty['title'] = "Begraafplaats";
        $begraafplaatsProperty['name'] = "begraafplaats";
        $begraafplaatsProperty['type'] = "string";
        $begraafplaatsProperty['format'] = "string";
 //?       $begraafplaatsProperty['iri'] = "";
        $begraafplaatsProperty['required'] = true;
 //!       $begraafplaatsProperty = $commonGroundService->createResource($begraafplaatsProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //grafsoort property
        $grafsoortProperty = [];
        $grafsoortProperty['title'] = "Soort Graf";
        $grafsoortProperty['name'] = "grafsoort";
        $grafsoortProperty['type'] = "string";
        $grafsoortProperty['format'] = "string";
 //?       $grafsoortProperty['iri'] = "";
        $grafsoortProperty['required'] = true;
 //!       $grafsoortProperty = $commonGroundService->createResource($grafsoortProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //startdatumtijd property
        $startdatumtijdProperty = [];
        $startdatumtijdProperty['title'] = "Start datum en tijd";
        $startdatumtijdProperty['name'] = "startdatumtijd";
        $startdatumtijdProperty['type'] = "datetime";
        $startdatumtijdProperty['format'] = "yy-m-d H:m:s";
 //?       $startdatumtijdProperty['iri'] = "";
        $startdatumtijdProperty['required'] = true;
 //!       $startdatumtijdProperty = $commonGroundService->createResource($startdatumtijdProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //enddatumtijd property
        $enddatumtijdProperty = [];
        $enddatumtijdProperty['title'] = "Eind datum en tijd";
        $enddatumtijdProperty['name'] = "enddatumtijd";
        $enddatumtijdProperty['type'] = "datetime";
        $enddatumtijdProperty['format'] = "yy-m-d H:m:s";
 //?       $enddatumtijdProperty['iri'] = "";
        $enddatumtijdProperty['required'] = true;
 //!       $enddatumtijdProperty = $commonGroundService->createResource($enddatumtijdProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //artikelen property
        $artikelenProperty = [];
        $artikelenProperty['title'] = "Artikelen";
        $artikelenProperty['name'] = "artikelen";
        $artikelenProperty['type'] = "array";
        $artikelenProperty['format'] = "string";
        $artikelenProperty['minItems'] = 0;
        $artikelenProperty['maxItems'] = 50;
        //?       $artikelenProperty['iri'] = "";
        $artikelenProperty['required'] = false;
 //!       $artikelenProperty = $commonGroundService->createResource($artikelenProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //overledene property
        $overledeneProperty = [];
        $overledeneProperty['title'] = "Overledene";
        $overledeneProperty['name'] = "overledene";
        $overledeneProperty['type'] = "string";
        $overledeneProperty['format'] = "string";
 //?       $overledeneProperty['iri'] = "";
        $overledeneProperty['required'] = true;
 //!       $overledeneProperty = $commonGroundService->createResource($enddatumtijdProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //belanghebbende property
        $belanghebbendeProperty = [];
        $belanghebbendeProperty['title'] = "Belanghebbende";
        $belanghebbendeProperty['name'] = "belanghebbende";
        $belanghebbendeProperty['type'] = "string";
        $belanghebbendeProperty['format'] = "string";
 //?       $belanghebbendeProperty['iri'] = "";
        $belanghebbendeProperty['required'] = true;
 //!       $belanghebbendeProperty = $commonGroundService->createResource($belanghebbendeProperty, $commonGroundService->getComponent('vtc')['href'].'/properties');

        //sections (ptc)
        //Gemeente section voor begraafplaats stage
        $gemeenteSection = [];
        $gemeenteSection['name'] = "Gemeente section";
        $gemeenteSection['description'] = "This is the section where the user can select a Gemeente";
        $gemeenteSection['properties'] = $gemeenteProperty;
 //!       $gemeenteSection = $commonGroundService->createResource($gemeenteSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Begraafplaats section voor begraafplaats stage
        $begraafplaatsSection = [];
        $begraafplaatsSection['name'] = "Begraafplaats section";
        $begraafplaatsSection['description'] = "This is the section where the user can select a Begraafplaats";
        $begraafplaatsSection['properties'] = $begraafplaatsProperty;
 //!       $begraafplaatsSection = $commonGroundService->createResource($begraafplaatsSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Grafsoort section voor begraafplaats stage
        $grafsoortSection = [];
        $grafsoortSection['name'] = "Grafsoort section";
        $grafsoortSection['description'] = "This is the section where the user can select a Soort Graf";
        $grafsoortSection['properties'] = $grafsoortProperty;
 //!       $grafsoortSection = $commonGroundService->createResource($grafsoortSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Datumtijd section voor datumtijd stage
        $datumtijdSection = [];
        $datumtijdSection['name'] = "Datum en tijd section";
        $datumtijdSection['description'] = "This is the section where the user can select a start and end Datum en Tijd";
        $datumtijdSectionProperties = [];
        $datumtijdSectionProperties[0] = $startdatumtijdProperty;
        $datumtijdSectionProperties[1] = $enddatumtijdProperty;
        $datumtijdSection['properties'] = $datumtijdSectionProperties;
 //!       $datumtijdSection = $commonGroundService->createResource($datumtijdSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Artikelen section voor artikelen stage
        $artikelenSection = [];
        $artikelenSection['name'] = "Artikelen section";
        $artikelenSection['description'] = "This is the section where the user can select Artikelen";
        $artikelenSection['properties'] = $artikelenProperty;
 //!       $artikelenSection = $commonGroundService->createResource($artikelenSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Overledene section voor overledene stage
        $overledeneSection = [];
        $overledeneSection['name'] = "Overledene section";
        $overledeneSection['description'] = "This is the section where the user can select a Overledene";
        $overledeneSection['properties'] = $overledeneProperty;
 //!       $overledeneSection = $commonGroundService->createResource($overledeneSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

        //Belanghebbende section voor belanghebbende stage
        $belanghebbendeSection = [];
        $belanghebbendeSection['name'] = "Belanghebbende section";
        $belanghebbendeSection['description'] = "This is the section where the user can select a Belanghebbende";
        $belanghebbendeSection['properties'] = $belanghebbendeProperty;
 //!       $belanghebbendeSection = $commonGroundService->createResource($belanghebbendeSection, $commonGroundService->getComponent('ptc')['href'].'/sections');

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
 //!       $begraafplaatsStage = $commonGroundService->createResource($begraafplaatsStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //datum en tijd stage
        $datumtijdStage = [];
        $datumtijdStage['name'] = "Datum en Tijd";
        $datumtijdStage['description'] = "Kies een Datum en Tijd waarop de begrafenis zal plaatsvinden";
        $datumtijdStage['icon'] = "fa fa-calendar";
        $datumtijdStage['slug'] = "datumtijd";
        $datumtijdStage['sections'] = $datumtijdSection;
 //!       $datumtijdStage['previous'] = "url begraafplaats stage";
 //!       $datumtijdStage = $commonGroundService->createResource($datumtijdStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //artikelen stage
        $artikelenStage = [];
        $artikelenStage['name'] = "Artikelen";
        $artikelenStage['description'] = "Selecteer artikelen voor de begrafenis";
        $artikelenStage['icon'] = "fa fa-tasks";
        $artikelenStage['slug'] = "artikelen";
        $datumtijdStage['sections'] = $artikelenSection;
 //!       $artikelenStage['previous'] = "url datumtijd stage";
 //!       $artikelenStage = $commonGroundService->createResource($artikelenStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //overledene stage
        $overledeneStage = [];
        $overledeneStage['name'] = "Overledene";
        $overledeneStage['description'] = "Selecteer hier de gegevens van de overledene";
        $overledeneStage['icon'] = "fa fa-id-card-o";
        $overledeneStage['slug'] = "overledene";
        $datumtijdStage['sections'] = $overledeneSection;
 //!       $overledeneStage['previous'] = "url artikelen stage";
 //!       $overledeneStage = $commonGroundService->createResource($overledeneStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //belanghebbende stage
        $belanghebbendeStage = [];
        $belanghebbendeStage['name'] = "Belanghebbende";
        $belanghebbendeStage['description'] = "Selecteer hier de gegevens van de belanghebbende";
        $belanghebbendeStage['icon'] = "fa fa-id-card-o";
        $belanghebbendeStage['slug'] = "belanghebbende";
        $datumtijdStage['sections'] = $belanghebbendeSection;
 //!       $belanghebbendeStage['previous'] = "url overledene stage";
 //!       $belanghebbendeStage = $commonGroundService->createResource($belanghebbendeStage, $commonGroundService->getComponent('ptc')['href'].'/stages');

        //properties list for request_type
        $properties = [];
        $properties['gemeente'] = "";
        $properties['begraafplaats'] = "";
        $properties['grafsoort'] = "";
        $properties['startdatumtijd'] = new \DateTime();
        $properties['enddatumtijd'] = new \DateTime();
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
 //!       $request_type = $commonGroundService->createResource($request_type, $commonGroundService->getComponent('vtc')['href'].'/request_types');

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
 //!       $process_type['requestType'] = $request_type['@id'];
 //!       $process_type = $commonGroundService->createResource($process_type, $commonGroundService->getComponent('ptc')['href'].'/process_types');

        //submitter (vrc)
        $submitter = [];
        $submitter['brp'] = $ingeschrevenpersoon1;
 //!       $submitter = $commonGroundService->createResource($submitter, $commonGroundService->getComponent('vrc')['href'].'/submitters');

        //properties list for request
        $properties['gemeente'] = "https://wrc.dev.begraven.zaakonline.nl/organizations/429e66ef-4411-4ddb-8b83-c637b37e88b5";
        $properties['begraafplaats'] = "https://grc.dev.begraven.zaakonline.nl/cemeteries/b38e2efd-6f5a-4bba-b755-50accf15372f";
        $properties['grafsoort'] = "https://grc.dev.begraven.zaakonline.nl/grave_types/429e66ef-4411-4ddb-8b83-c637b37e88b5";
        $properties['startdatumtijd'] = new \DateTime();
        $properties['enddatumtijd'] = $properties['startdatumtijd']->modify('+ 2 hours');
        $properties['artikelen'] = array("Gebruik Orgel", "CD");
        $properties['overledene'] = $ingeschrevenpersoon2;
        $properties['belanghebbende'] = $ingeschrevenpersoon3;

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






