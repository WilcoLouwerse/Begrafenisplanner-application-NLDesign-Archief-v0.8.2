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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class DeveloperController
 * @package App\Controller
 * @Route("/grave")
 */
class GraveController extends AbstractController
{

    /**
     * @Route("/view")
     * @Template
     */
    public function viewAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];

        $variables['graves'] = $commonGroundService->getResourceList($commonGroundService->getComponent('grc')['href'].'/graves')['hydra:member'];

        return $variables;
    }

    /**
     * @Route("/add")
     * @Template
     */
    public function addAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];
        $variables['cemeteries'] = [];

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
        $variables['gravetypes'] = $commonGroundService->getResourceList($commonGroundService->getComponent('grc')['href'].'/grave_types')['hydra:member'];

        if(isset($_POST['Submit']))
        {
            $timezone = new DateTimeZone('Europe/Amsterdam');
            $date = \DateTime::createFromFormat('yy-m-d H:m:s', 'yy-m-d H:m:s', $timezone);

            $grave = [];
            $grave['dateCreated'] = $date;
            $grave['dateModified'] = $date;
            $grave['description'] = $_POST['Description'];
            $cemetery = $_POST['Cemetery'];
            if($cemetery != "Select Cemetery")
            {
                $grave['cemetery'] = $cemetery;
            }
            $grave['deceased'] = $_POST['Deceased'];
            $grave['acquisition'] = $_POST['Acquisition'];
            $grave['reference'] = $_POST['Reference'];
            $graveType = $_POST['GraveType'];
            if($cemetery != "Select GraveType")
            {
                $grave['graveType'] = $graveType;
            }
            $grave['status'] = $_POST['Status'];
            $grave['location'] = $_POST['Location'];
            $grave['position'] = (int) $_POST['Position'];
            $commonGroundService->createResource($grave, $commonGroundService->getComponent('grc')['href'].'/graves');
        }

        return $variables;
    }

}
