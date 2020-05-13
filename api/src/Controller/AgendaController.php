<?php


namespace App\Controller;

use App\Service\ApplicationService;
//use App\Service\RequestService;
use App\Service\CommonGroundService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeZone;

/**
 * Class DeveloperController
 * @package App\Controller
 * @Route("/agenda")
 */
class AgendaController extends AbstractController
{
    /**
     * @Route("/calendar")
     * @Template
     */
    public function calendarAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];
        $variables['calendars'] = [];

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

        return $variables;
    }
    /**
     * @Route("/event")
     * @Template
     */
    public function eventAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];
        $variables['events'] = [];
        $variables['calendars'] = [];

        $events = $commonGroundService->getResourceList($commonGroundService->getComponent('arc')['href'].'/events');
        if(key_exists("hydra:view", $events))
        {
            $lastPageEvents = (int) str_replace("/events?page=", "", $events["hydra:view"]["hydra:last"]);
            for ($i = 1; $i <= $lastPageEvents; $i++)
            {
                $variables['events'] = array_merge($variables['events'], $commonGroundService->getResourceList($commonGroundService->getComponent('arc')['href'].'/events', ['page'=>$i])["hydra:member"]);
            }
        }
        else
        {
            $variables["events"] = $events["hydra:member"];
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

        return $variables;
    }

    /**
     * @Route("/add")
     * @Template
     */
    public function addAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];

        $variables['calendars'] = [];

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

        if(isset($_POST['Submit']))
        {
            $event = [];
            $event['name'] = $_POST['Name'];
            $event['description'] = $_POST['Description'];
            $event['startDate'] = $_POST['StartDate'];
            $event['endDate'] = $_POST['EndDate'];
            $calendar = $_POST['Calendar'];
            if($calendar != "Select Calendar")
            {
                $event['calendar'] = $calendar;
            }

            $commonGroundService->createResource($event, $commonGroundService->getComponent('arc')['href'].'/events');
        }

        return $variables;
    }
}
