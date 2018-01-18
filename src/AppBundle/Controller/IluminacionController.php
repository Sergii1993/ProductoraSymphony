<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Iluminacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Iluminacion controller.
 *
 * @Route("iluminacion")
 */
class IluminacionController extends Controller
{
    /**
     * Lists all iluminacion entities.
     *
     * @Route("/", name="iluminacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $criterios['tipo']='robotica';
        $iluminacions = $em->getRepository('AppBundle:Iluminacion')->findBy($criterios);

        return $this->render('iluminacion/index.html.twig', array(
            'iluminacions' => $iluminacions,
        ));
    }

    /**
     * Creates a new iluminacion entity.
     *
     * @Route("/new", name="iluminacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $iluminacion = new Iluminacion();
        $form = $this->createForm('AppBundle\Form\IluminacionType', $iluminacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($iluminacion);
            $em->flush();

            return $this->redirectToRoute('iluminacion_show', array('id' => $iluminacion->getId()));
        }

        return $this->render('iluminacion/new.html.twig', array(
            'iluminacion' => $iluminacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a iluminacion entity.
     *
     * @Route("/{id}", name="iluminacion_show")
     * @Method("GET")
     */
    public function showAction(Iluminacion $iluminacion)
    {
        $deleteForm = $this->createDeleteForm($iluminacion);

        return $this->render('iluminacion/show.html.twig', array(
            'iluminacion' => $iluminacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing iluminacion entity.
     *
     * @Route("/{id}/edit", name="iluminacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Iluminacion $iluminacion)
    {
        $deleteForm = $this->createDeleteForm($iluminacion);
        $editForm = $this->createForm('AppBundle\Form\IluminacionType', $iluminacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('iluminacion_edit', array('id' => $iluminacion->getId()));
        }

        return $this->render('iluminacion/edit.html.twig', array(
            'iluminacion' => $iluminacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a iluminacion entity.
     *
     * @Route("/{id}", name="iluminacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Iluminacion $iluminacion)
    {
        $form = $this->createDeleteForm($iluminacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($iluminacion);
            $em->flush();
        }

        return $this->redirectToRoute('iluminacion_index');
    }

    /**
     * Creates a form to delete a iluminacion entity.
     *
     * @param Iluminacion $iluminacion The iluminacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Iluminacion $iluminacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('iluminacion_delete', array('id' => $iluminacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
