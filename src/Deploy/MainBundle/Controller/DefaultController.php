<?php

namespace Deploy\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Deploy\MainBundle\Entity\Server;

class DefaultController extends Controller
{
    public function indexAction()
    {           
        $servers = array();

        if( $this->container->get('security.context')->isGranted('ROLE_ADMIN') ){
            $em = $this->getDoctrine()->getManager();
            $websitesEnable = $em->getRepository('DeployMainBundle:Website')->findAll();
        } else {
            $user= $this->get('security.context')->getToken()->getUser(); 
            $websitesEnable = $user->getWebsites();    
        }

        foreach ($websitesEnable as $website) {
            $servers[$website->getServer()->getId()]['name'] = $website->getServer()->getName();
            $servers[$website->getServer()->getId()]['ip'] = $website->getServer()->getIp();
            $servers[$website->getServer()->getId()]['websites'][] = $website;
        }

        return $this->render('DeployMainBundle:Default:index.html.twig', array('servers' => $servers));
    }    

    /**
     * Finds and displays a Website entity in frontoffice.
     *
     */
    public function showWebsitesAction(Server $server)
    {
        return $this->render('DeployMainBundle:Default:showWebsites.html.twig', array(
            'server' => $server
        ));
    }
}
