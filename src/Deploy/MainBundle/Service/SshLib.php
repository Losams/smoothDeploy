<?php 

namespace Deploy\MainBundle\Service;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

use Deploy\MainBundle\Entity\Website;

class SshLib 
{
	protected $em;
	protected $container;
    protected $connexion;

    protected $website;
    protected $server;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    /**
     * Set the website
     * @param Website
     */
    public function setWebsite(Website $website) {
        $this->website = $website;
        $this->server = $website->getServer();
    }

    /**
     * Connect to the server with ssh (port 22)
     * @return [bool] connect
     */
    private function connect() {
        $ip   = $this->server->getIp();
        $user = $this->website->getSshUser();
        $pwd  = $this->website->getSshPwd();

        $securityLib = $this->container->get('deploy_main.securityLib');
        $pwd = $securityLib->decrypt($pwd);

        $connexion = \ssh2_connect($ip, 22);
        if (@ssh2_auth_password($connexion, $user, $pwd)) {
             $this->connexion = $connexion;
             return true;
        } else {
            return false;    
        } 
    }

    /**
     * Launch exec on server after connexion
     * @param  [string] command
     * @return [string] output of the server
     */
    private function execute($exec) {
        $connexion = $this->connexion;
        
        $stream = ssh2_exec($connexion, $exec);
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        $output = stream_get_contents($stream_out);

        return $output;
    }

    /**
     * Launch all the needed to connect, and pull on server
     * @param  [string] branch to pull
     * @return [string] output
     */
    public function pull($branch = null) {      
        if ($branch) {
            $exec = 'cd '.$this->website->getSshPath().'; git pull origin '.$branch.' 2>&1';
        } else {
            if ($defaultBranch = $this->website->getEnvironment()->getDefaultBranch()) {
                $exec = 'cd '.$this->website->getSshPath().'; git pull origin '.$defaultBranch.' 2>&1';
            }
        }

        if(!$this->connect()) {
            return 'Error during connexion';
        }

        $output = $this->execute($exec);

        return $output;
    }

    /**
     * Launch all the needed to connect, and check (git status) on server
     * @param  [string] branch to pull
     * @return [string] output
     */
    public function status() {      
        $exec = 'cd '.$this->website->getSshPath().'; git status 2>&1';

        if(!$this->connect()) {
            return 'Error during connexion';
        }

        $output = $this->execute($exec);

        return $output;
    }

}