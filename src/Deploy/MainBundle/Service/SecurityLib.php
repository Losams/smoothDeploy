<?php 

namespace Deploy\MainBundle\Service;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class SecurityLib
{
	protected $em;
	protected $request;
    
    protected $encryptedKey;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
        $this->encryptedKey = $this->container->getParameter('encryptedKey');
    }

    public function encrypt($string) {
        // ENCRYPT
        $key = $this->encryptedKey;
        $encrypted = base64_encode(\mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));   

        return $encrypted;
    }

    public function decrypt($encrypted) {
        // DECRYPT
        $key = $this->encryptedKey;
        $decrypted = rtrim(\mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

        return $decrypted;   
    }
}