<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sonido;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sonido controller.
 *
 * @Route("sonido")
 */
class SonidoController extends Controller
{
    /**
     * Lists all sonido entities.
     *
     * @Route("/", name="sonido_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sonidos = $em->getRepository('AppBundle:Sonido')->findAll();

        return $this->render('sonido/index.html.twig', array(
            'sonidos' => $sonidos,
        ));
    }

    /**
     * Creates a new sonido entity.
     *
     * @Route("/new", name="sonido_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sonido = new Sonido();
        $form = $this->createForm('AppBundle\Form\SonidoType', $sonido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sonido);
            $em->flush();

            return $this->redirectToRoute('sonido_show', array('id' => $sonido->getId()));
        }

        return $this->render('sonido/new.html.twig', array(
            'sonido' => $sonido,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sonido entity.
     *
     * @Route("/{id}", name="sonido_show")
     * @Method("GET")
     */
    public function showAction(Sonido $sonido)
    {
        $deleteForm = $this->createDeleteForm($sonido);

        return $this->render('sonido/show.html.twig', array(
            'sonido' => $sonido,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sonido entity.
     *
     * @Route("/{id}/edit", name="sonido_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sonido $sonido)
    {
        $deleteForm = $this->createDeleteForm($sonido);
        $editForm = $this->createForm('AppBundle\Form\SonidoType', $sonido);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sonido_edit', array('id' => $sonido->getId()));
        }

        return $this->render('sonido/edit.html.twig', array(
            'sonido' => $sonido,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sonido entity.
     *
     * @Route("/{id}", name="sonido_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sonido $sonido)
    {
        $form = $this->createDeleteForm($sonido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sonido);
            $em->flush();
        }

        return $this->redirectToRoute('sonido_index');
    }

    /**
     * Creates a form to delete a sonido entity.
     *
     * @param Sonido $sonido The sonido entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sonido $sonido)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sonido_delete', array('id' => $sonido->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
