<?php

namespace Deploy\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr' => array('class' => 'form-control')))
            ->add('ip', 'text', array('attr' => array('class' => 'form-control')))
            ->add('submit', 'submit', array('label' => 'Enregistrer', 'attr' => array('class' => 'btn btn-primary btn-submit')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Deploy\MainBundle\Entity\Server'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deploy_mainbundle_server';
    }
}
