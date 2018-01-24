<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Message controller.
 *
 * @Route("message")
 */
class MessageController extends Controller
{
    /**
     * Lists all message entities.
     *
     * @Route("/", name="message_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$messages = $em->getRepository('AppBundle:Message')->findAll();
        $page = "index";

        $query = $em->createQuery( // Liste des priorités
            'SELECT m
            FROM AppBundle:Message m
            WHERE m.expeditor = :user
            ORDER BY m.date ASC'
        )->setParameter('user', $this->getUser());

        $messages = $query->getResult();

        return $this->render('message/index.html.twig', array(
            'messages' => $messages,
            'page' => $page,
        ));
    }

    /**
     * Creates a new message entity.
     *
     * @Route("/new", name="message_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm('AppBundle\Form\MessageType', $message);
        $form->handleRequest($request);
        $page = "new";

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->setExpeditor($this->getUser());
            /*$user_array=array();
            $user_array[] = $this->getUser();
            $message->setFosUser($user_array);*/
            $message->setDate(new \DateTime());
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('message_show', array('idmessage' => $message->getIdmessage()));
        }

        return $this->render('message/new.html.twig', array(
            'message' => $message,
            'form' => $form->createView(),
            'page' => $page,
        ));
    }

    /**
     * Finds and displays a message entity.
     *
     * @Route("/{idmessage}", name="message_show")
     * @Method("GET")
     */
    public function showAction(Message $message)
    {
        $deleteForm = $this->createDeleteForm($message);
        $page = "show";

        return $this->render('message/show.html.twig', array(
            'message' => $message,
            'delete_form' => $deleteForm->createView(),
            'page' => $page,
        ));
    }

    /**
     * Displays a form to edit an existing message entity.
     *
     * @Route("/{idmessage}/edit", name="message_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Message $message)
    {
        $deleteForm = $this->createDeleteForm($message);
        $editForm = $this->createForm('AppBundle\Form\MessageType', $message);
        $editForm->handleRequest($request);
        $page = "edit";

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_edit', array('idmessage' => $message->getIdmessage()));
        }

        return $this->render('message/edit.html.twig', array(
            'message' => $message,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page' => $page,
        ));
    }

    /**
     * Deletes a message entity.
     *
     * @Route("/{idmessage}", name="message_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Message $message)
    {
        $form = $this->createDeleteForm($message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('message_index');
    }

    /**
     * Creates a form to delete a message entity.
     *
     * @param Message $message The message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Message $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('message_delete', array('idmessage' => $message->getIdmessage())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
