<?php

namespace Deploy\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Deploy\MainBundle\Entity\Server;
use Deploy\MainBundle\Form\ServerType;

/**
 * Server controller.
 *
 */
class ServerController extends Controller
{

    /**
     * Lists all Server entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DeployMainBundle:Server')->findAll();

        return $this->render('DeployMainBundle:Server:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Server entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Server();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('server'));
        }

        return $this->render('DeployMainBundle:Server:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Server entity.
     *
     * @param Server $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Server $entity)
    {
        $form = $this->createForm(new ServerType(), $entity, array(
            'action' => $this->generateUrl('server_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Server entity.
     *
     */
    public function newAction()
    {
        $entity = new Server();
        $form   = $this->createCreateForm($entity);

        return $this->render('DeployMainBundle:Server:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Server entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DeployMainBundle:Server')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Server entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DeployMainBundle:Server:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Server entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DeployMainBundle:Server')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Server entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DeployMainBundle:Server:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Server entity.
    *
    * @param Server $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Server $entity)
    {
        $form = $this->createForm(new ServerType(), $entity, array(
            'action' => $this->generateUrl('server_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Server entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DeployMainBundle:Server')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Server entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('server_edit', array('id' => $id)));
        }

        return $this->render('DeployMainBundle:Server:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Server entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DeployMainBundle:Server')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Server entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('server'));
    }

    /**
     * Creates a form to delete a Server entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('server_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
