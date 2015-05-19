<?php

namespace Deploy\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class WebsiteType extends AbstractType
{

    private $securityLib;

    /**
     * @param SecurityLib
     */
    public function __construct(\Deploy\MainBundle\Service\SecurityLib $securityLib)
    {
        $this->securityLib = $securityLib;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr' => array('class' => 'form-control')))
            ->add('environment', 'entity', array('class' => 'DeployMainBundle:Environment', 'attr' => array('class' => 'form-control')))
            ->add('sshUser', 'text', array('attr' => array('class' => 'form-control')))
            ->add('sshPwd', 'text', array('attr' => array('class' => 'form-control')))
            ->add('sshPath', 'text', array('attr' => array('class' => 'form-control')))
            ->add('server', 'entity', array('class' => 'DeployMainBundle:Server', 'attr' => array('class' => 'form-control')))
            ->add('submit', 'submit', array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-primary btn-submit')))
        ;

        $builder->addEventListener( FormEvents::SUBMIT, array($this, 'onSubmit') );
        $builder->addEventListener( FormEvents::PRE_SET_DATA, array($this, 'onPreSetData') );
    }

    public function onPreSetData(FormEvent $event)
    {
        $datas = $event->getData();
        $pwd = $datas->getSshPwd();

        if ($pwd) {
            $securityLib = $this->securityLib;
            $decryptedPwd = $securityLib->decrypt($pwd);
            $datas->setSshPwd($decryptedPwd);
        }
    }

    public function onSubmit(FormEvent $event)
    {
        $datas = $event->getData();
        $pwd = $datas->getSshPwd();

        if ($pwd) {
            $securityLib = $this->securityLib;
            $encryptedPwd = $securityLib->encrypt($pwd);
            $datas->setSshPwd($encryptedPwd);
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Deploy\MainBundle\Entity\Website'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deploy_mainbundle_website';
    }
}
