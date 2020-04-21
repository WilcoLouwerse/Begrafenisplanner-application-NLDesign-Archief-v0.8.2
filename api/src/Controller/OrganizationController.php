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
 * @Route("/organization")
 */
class OrganizationController extends AbstractController
{
    /**
     * @Route("/organization")
     * @Template
     */
    public function organizationAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];

        $variables['organizations'] = $commonGroundService->getResourceList($commonGroundService->getComponent('wrc')['href'].'/organizations');

        return $variables;
    }

    /**
     * @Route("/addorganization")
     * @Template
     */
    public function addorganizationAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];

        if(isset($_POST['Submit']))
        {
            $timezone = new DateTimeZone('Europe/Amsterdam');
            $date     = \DateTime::createFromFormat('yy-m-d H:m:s', 'yy-m-d H:m:s', $timezone);

            $organization = [];
            $organization['dateCreated'] = $date;
            $organization['dateModified'] = $date;
            $organization['name'] = $_POST['Name'];
            $organization['description'] = $_POST['Description'];
            $organization['rsin'] = $_POST['Rsin'];
            $organization['chamberOfComerce'] = $_POST['ChamberOfCommerce'];
            $commonGroundService->createResource($organization, $commonGroundService->getComponent('wrc')['href'].'/organizations');
        }

        return $variables;
    }
}
