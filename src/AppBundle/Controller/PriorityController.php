<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Priority;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Priority controller.
 *
 * @Route("priority")
 */
class PriorityController extends Controller
{




    /**
     * Deletes a priority entity.
     *
     * @Route("/{idpriority}", name="priority_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Priority $priority)
    {
        $form = $this->createDeleteForm($priority);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($priority);
            $em->flush();
        }

        return $this->redirectToRoute('priority_index');
    }

}
