<?php

namespace Deploy\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\HttpFoundation\Request; 

use Deploy\MainBundle\Entity\Website;

class ApiController extends Controller
{
    public function indexAction(Website $website, Request $request)
    {
        // check right
        // @TODO

        if ($website) {
            if($request->isXmlHttpRequest()) 
            {
                $sshLib = $this->container->get('deploy_main.sshLib');
                $sshLib->setWebsite($website);
                $data = $sshLib->pull();

                // $data = "retour ajax";
                return new JsonResponse(nl2br($data));
            } else {
                return new JsonResponse(false);
            }
        }
    }    

    public function CheckAction(Website $website, Request $request)
    {
        // check right
        // @TODO
        
        if ($website) {
            if($request->isXmlHttpRequest()) 
            {
                $sshLib = $this->container->get('deploy_main.sshLib');
                $sshLib->setWebsite($website);
                $data = $sshLib->status();

                if (strpos($data, 'working directory clean')) {
                    $html = $this->renderView('DeployMainBundle:Part:checkSuccess.html.twig');
                } else {
                    $html = $this->renderView('DeployMainBundle:Part:checkDanger.html.twig', array('data' => nl2br($data)));
                }

                $return['html'] = $html;

                return new JsonResponse($return);
            } else {
                return new JsonResponse(false);
            }
        }
    }    
}
