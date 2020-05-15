<?php


namespace App\Controller;

use App\Service\ApplicationService;
//use App\Service\RequestService;
use App\Service\CommonGroundService;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class DeveloperController
 * @package App\Controller
 * @Route("/cemetery")
 */
class CemeteryController extends AbstractController
{

    /**
     * @Route("/view")
     * @Template
     */
    public function viewAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];
        $variables['cemeteries'] = [];
        $variables['calendars'] = [];

        $cemeteries = $commonGroundService->getResourceList($commonGroundService->getComponent('grc')['href'].'/cemeteries');
        if(key_exists("hydra:view", $cemeteries))
        {
            $lastPageCemeteries = (int) str_replace("/cemeteries?page=", "", $cemeteries["hydra:view"]["hydra:last"]);
            for ($i = 1; $i <= $lastPageCemeteries; $i++)
            {
                $variables['cemeteries'] = array_merge($variables['cemeteries'], $commonGroundService->getResourceList($commonGroundService->getComponent('grc')['href'].'/cemeteries', ['page'=>$i])["hydra:member"]);
            }
        }
        else
        {
            $variables["cemeteries"] = $cemeteries["hydra:member"];
        }

        $calendars = $commonGroundService->getResourceList($commonGroundService->getComponent('arc')['href'].'/calendars');
        if(key_exists("hydra:view", $calendars))
        {
            $lastPageCalendars = (int) str_replace("/calendars?page=", "", $calendars["hydra:view"]["hydra:last"]);
            for ($i = 1; $i <= $lastPageCalendars; $i++)
            {
                $variables['calendars'] = array_merge($variables['calendars'], $commonGroundService->getResourceList($commonGroundService->getComponent('arc')['href'].'/calendars', ['page'=>$i])["hydra:member"]);
            }
        }
        else
        {
            $variables["calendars"] = $calendars["hydra:member"];
        }

        $variables['organizations'] = $commonGroundService->getResourceList($commonGroundService->getComponent('wrc')['href'].'/organizations')['hydra:member'];

        return $variables;
    }

    /**
     * @Route("/add")
     * @Template
     */
    public function addAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];

        $variables['organizations'] = $commonGroundService->getResourceList($commonGroundService->getComponent('wrc')['href'].'/organizations');


        if(isset($_POST['Submit']))
        {
            $timezone = new DateTimeZone('Europe/Amsterdam');
            $date     = \DateTime::createFromFormat('yy-m-d H:m:s', 'yy-m-d H:m:s', $timezone);

            $cemetery = [];
            $cemetery['dateCreated'] = $date;
            $cemetery['dateModified'] = $date;
            $cemetery['reference'] = $_POST['Reference'];
            $organization = $_POST['Organization'];
            if($organization != "Select Organization")
            {
                $cemetery['organization'] = $organization;
                $organizationName = $commonGroundService->getResourceList($organization)['name'];
            }

            $calendar = [];
            $calendar['dateCreated'] = $date;
            $calendar['dateModified'] = $date;
            $calendar['name'] = "Calendar " . $_POST['Reference'];
            $calendar['description'] = "Calendar voor begraafplaats " . $_POST['Reference'] . " in gemeente " . $organizationName;
            $calendar['timeZone'] = "CET";
            $calendar = $commonGroundService->createResource($calendar, $commonGroundService->getComponent('arc')['href'].'/calendars');

            $cemetery['calendar'] = $calendar['@id'];

            $commonGroundService->createResource($cemetery, $commonGroundService->getComponent('grc')['href'].'/cemeteries');
        }

        return $variables;
    }

}
