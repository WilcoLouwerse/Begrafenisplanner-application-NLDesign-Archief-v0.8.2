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
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/organization")
     * @Template
     */
    public function organizationAction(Session $session, $slug = false, Request $httpRequest, CommonGroundService $commonGroundService, ApplicationService $applicationService)
    {
        $variables = [];

        $variables['organizationContacts'] = $commonGroundService->getResourceList($commonGroundService->getComponent('cc')['href'].'/organizations');

        return $variables;
    }
}
