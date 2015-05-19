<?php

namespace Deploy\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Deploy\MainBundle\Entity\Website;

class RightController extends Controller
{
    public function indexAction(Request $request)
    {
        $repoUser = $this->getDoctrine()->getRepository('DeployUserBundle:User');

        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();

            $rights = $request->request->get('rights', array());

            $repoWebsite = $this->getDoctrine()->getRepository('DeployMainBundle:Website');
            $websites = $repoWebsite->findAll();
            
            foreach ($rights as $user_id => $right) {
                $user = $repoUser->find($user_id);

                foreach ($websites as $website) {
                    if (array_key_exists($website->getId(), $right)) {
                        $user->addWebsite($website);
                    } else {
                        $user->removeWebsite($website);
                    }
                }
                
                $em->persist($user);
            }

            $this->get('session')->getFlashBag()->add( 'success', $this->get('translator')->trans('Your change have been saved !') );
            $em->flush();
        }

        
        $users = $repoUser->findAll();

        $repoServer = $this->getDoctrine()->getRepository('DeployMainBundle:Server');
        $servers = $repoServer->findAll();

        $arrayRights = array();
        $arrayUsers = array();

        $first = true;

        foreach ($servers as $server) {
            $websitesServer = $server->getWebsites();
            $arrayRights[$server->getId()]['name'] = $server->getName();
            $arrayRights[$server->getId()]['websites'] = array();

            foreach ($websitesServer as $website) {
                $arrayRights[$server->getId()]['websites'][$website->getId()] = array('name' => $website->getName(), 'users' => array());
                foreach ($users as $user) {
                    $access = $user->hasAccess($website);
                    $arrayRights[$server->getId()]['websites'][$website->getId()]['users'][$user->getId()] = array('name' => $user->getUsername(), 'isIn' => $access);

                    // init User Array()
                    if ($first) {
                        $arrayUsers[$user->getId()] = $user->getUsername();
                    }
                }

                $first = false;
            }
        }        

        return $this->render('DeployUserBundle:Right:index.html.twig', array('rights' => $arrayRights, 'users' => $arrayUsers));
    }
}
