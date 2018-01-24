<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;

use AppBundle\Entity\Priority;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


/**
 * Priority controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="indexAdmin")
     */
    public function indexAction()
    {
        $page = "index";
        return $this->render('Admin/index.html.twig', array(
            'page' => $page,

        ));
    }

    /**
     * @Route("/user", name="userAdmin")
     */
    public function userAdminction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        $page = "index";

        return $this->render('Admin/users.html.twig', array(
            'users' => $users,
            'page' => $page

        ));
    }

    /**
     * @Route("/user/{id}/promote", name="promoteUserdmin")
     */
    public function userPromotAdminAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        $user->addRole('ROLE_ADMIN');

        $em->flush();

        return $this->redirectToRoute('userAdmin');

    }


    /**
     * @Route("/user/{id}/disgrace", name="disgraceUserAdmin")
     */
    public function userDisgraceAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        $user->removeRole('ROLE_ADMIN');

        $em->flush();

        return $this->redirectToRoute('userAdmin');

    }

    /**
     * @Route("/user/{id}/remove", name="removeUserAdmin")
     */
    public function userRemoveAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();


        return $this->redirectToRoute('userAdmin');

    }

    /**
     * Lists all priority entities.
     *
     * @Route("/priority", name="PriorityAdmin")
     * @Method("GET")
     */
    public function PriorityAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $priorities = $em->getRepository('AppBundle:Priority')->findAll();
        $page = "index";
        return $this->render('admin/priority.html.twig', array(
            'priorities' => $priorities,
            'page' => $page

        ));
    }
    /**
     * Creates a new priority entity.
     *
     * @Route("/priority/new", name="newPriorityAdmin")
     * @Method({"GET", "POST"})
     */
    public function newPriorityAction(Request $request)
    {
        $priority = new Priority();
        $form = $this->createForm('AppBundle\Form\PriorityType', $priority);
        $form->handleRequest($request);
        $page="new";

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($priority);
            $em->flush();

            return $this->redirectToRoute('priority_show', array('idpriority' => $priority->getIdpriority()));
        }
        else{
            $form->get('color')->setData("#ffffff");
        }

        return $this->render('admin/priorityNew.html.twig', array(
            'priority' => $priority,
            'form' => $form->createView(),
            'page' => $page
        ));
    }




    /**
     * Displays a form to edit an existing priority entity.
     *
     * @Route("/priority/{idpriority}/edit", name="priority_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Priority $priority)
    {
        $deleteForm = $this->createDeleteForm($priority);
        $editForm = $this->createForm('AppBundle\Form\PriorityType', $priority);
        $editForm->handleRequest($request);
        $page = "edit";
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('priority_edit', array('idpriority' => $priority->getIdpriority()));
        }

        return $this->render('admin/priorityEdit.html.twig', array(
            'priority' => $priority,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page' => $page,

        ));
    }


    /**
     * Finds and displays a priority entity.
     *
     * @Route("/priority/{idpriority}", name="priority_show")
     * @Method("GET")
     */
    public function showAction(Priority $priority)
    {
        $deleteForm = $this->createDeleteForm($priority);
        $page = "show";
        return $this->render('admin/priorityShow.html.twig', array(
            'priority' => $priority,
            'delete_form' => $deleteForm->createView(),
            'page' => $page,

        ));
    }

    /**
     * Creates a form to delete a priority entity.
     *
     * @param Priority $priority The priority entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Priority $priority)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('priority_delete', array('idpriority' => $priority->getIdpriority())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
