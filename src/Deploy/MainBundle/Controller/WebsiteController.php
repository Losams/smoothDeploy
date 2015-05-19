<?php

namespace Deploy\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Deploy\MainBundle\Entity\Website;
use Deploy\MainBundle\Form\WebsiteType;

/**
 * Website controller.
 *
 */
class WebsiteController extends Controller
{

    /**
     * Lists all Website entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DeployMainBundle:Website')->findAll();

        return $this->render('DeployMainBundle:Website:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Website entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Website();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('website'));
        }

        return $this->render('DeployMainBundle:Website:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Website entity.
     *
     * @param Website $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Website $entity)
    {
        $formType = $this->container->get('deploy_main.website.form.type');
        $form = $this->createForm($formType, $entity, array(
            'action' => $this->generateUrl('website_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Website entity.
     *
     */
    public function newAction()
    {
        $entity = new Website();
        $form   = $this->createCreateForm($entity);

        return $this->render('DeployMainBundle:Website:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Website entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DeployMainBundle:Website')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DeployMainBundle:Website:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Website entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DeployMainBundle:Website')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DeployMainBundle:Website:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Website entity.
    *
    * @param Website $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Website $entity)
    {
        $formType = $this->container->get('deploy_main.website.form.type');
        $form = $this->createForm($formType, $entity, array(
            'action' => $this->generateUrl('website_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Website entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DeployMainBundle:Website')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('website_edit', array('id' => $id)));
        }

        return $this->render('DeployMainBundle:Website:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Website entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DeployMainBundle:Website')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('website'));
    }

    /**
     * Creates a form to delete a Website entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('website_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
