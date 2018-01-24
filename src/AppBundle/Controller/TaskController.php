<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Task controller.
 *
 * @Route("task")
 */
class TaskController extends Controller
{
    /**
     * Lists all task entities.
     *
     * @Route("/", name="task_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        //$tasks = $em->getRepository('AppBundle:Task')->findAll();
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $tasks = $em->getRepository('AppBundle:Task')->findAll();
        }
        else{
            $query = $em->createQuery(
                'SELECT t
            FROM AppBundle:User u, AppBundle:Task t
            WHERE u.id = t.usermaster
            AND t.usermaster = :user
            OR t.idtask IN(
            SELECT IDENTITY(pu.idtask) 
            FROM AppBundle:Task_User pu
            WHERE pu.user_id = :user
            AND pu.idtask = t.idtask
            )
            ORDER BY t.limitedate ASC'
            )->setParameter('user', $this->getUser());

            $tasks = $query->getResult();
        }

        $query = $em->createQuery(
            'SELECT pr
            FROM AppBundle:Priority pr, AppBundle:Task t
            WHERE pr.idpriority = t.priorityid
            ORDER BY pr.code ASC'
        );

        $priorities = $query->getResult();



        //$priorities = $em->getRepository('AppBundle:Priority')->findAll();
        $page = "index";

       return $this->render('task/index.html.twig', array(
            'tasks' => $tasks,
            'priorities' => $priorities,
            'page' => $page,
        ));
       //return var_dump($tasks);
    }

    /**
     * Creates a new task entity.
     *
     * @Route("/new", name="task_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm('AppBundle\Form\TaskType', $task);
        $form->handleRequest($request);
        $page = "new";

        if ($form->isSubmitted() && $form->isValid()) {
            // Affectation de la valeur du champs limitedate
            if ($form["is_date"]->getData() == 1) { // On recupere le champs de la date
                $dateInput = $form["date"]->getData(); // On recupere le champs de la date
                $timeInput = $form["time"]->getData(); //On recupere le champs de l'heure
                if ($form["is_time"]->getData() != 1) {
                    $myDateTime = \DateTime::createFromFormat('d-m-Y H:i:s', $dateInput." 23:59:00"); //Concatenation
                } else {
                    $myDateTime = \DateTime::createFromFormat(
                        'd-m-Y H:i:s',
                        $dateInput." ".$timeInput.":00"
                    ); //Concatenation
                }
                $timestramp = $myDateTime->format('Y-m-d H:i:s');
                $dateTime = \DateTime::createFromFormat("Y-m-d H:i:s", $timestramp);
                $task->setLimitedate($dateTime);
            }
            else{ // Si date de fin non définie
                $task->setLimitedate(null);
            }
            $em = $this->getDoctrine()->getManager();
            $task->setCreationDate(new \DateTime());
            $task->setUsermaster($this->getUser());
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_show', array('idtask' => $task->getIdtask()));
        }
        else{
            //Initialisation de l'input de la date
            $d = date("m-d-Y");
            $form->get('date')->setData($d);

            //Initialisation de l'input de l'heure
            $t = date("H:i");
            $form->get('time')->setData($t);
        }

        return $this->render('task/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
            'page' => $page,
        ));
    }

    /**
     * Finds and displays a task entity.
     *
     * @Route("/{idtask}", name="task_show")
     * @Method("GET")
     */
    public function showAction(Task $task)
    {
        $deleteForm = $this->createDeleteForm($task);

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM AppBundle:Project p
            WHERE p.idproject = :task
            ORDER BY p.limitedate ASC'
        )->setParameter('task', $task->getProjectmaster());

        $project = $query->getResult();
        $page = "show";
        return $this->render('task/show.html.twig', array(
            'task' => $task,
            'project' => $project,
            'delete_form' => $deleteForm->createView(),
            'page' => $page,
        ));
    }

    /**
     * Displays a form to edit an existing task entity.
     *
     * @Route("/{idtask}/edit", name="task_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Task $task)
    {
        $deleteForm = $this->createDeleteForm($task);
        $editForm = $this->createForm('AppBundle\Form\TaskType', $task);
        $editForm->handleRequest($request);
        $page = "edit";

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Affectation de la valeur du champs limitedate
            if ($editForm["is_date"]->getData() == 1){ // On recupere le champs de la date
                $dateInput = $editForm["date"]->getData(); // On recupere le champs de la date
                if ($editForm["is_time"]->getData() != 1){
                    $timeInput = "23:59";
                }
                else{
                    $timeInput = $editForm["time"]->getData(); //On recupere le champs de l'heure
                }
                $myDateTime = \DateTime::createFromFormat('d-m-Y H:i:s', $dateInput." ".$timeInput.":00"); //Concatenation
                $timestramp = $myDateTime->format('Y-m-d H:i:s');
                $dateTime = \DateTime::createFromFormat("Y-m-d H:i:s",$timestramp);
                $task->setLimitedate($dateTime);
            }
            else{ // Si date de fin non définie
                $task->setLimitedate(NULL);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task_edit', array('idtask' => $task->getIdtask()));
        }
        else{
            if( $editForm["date"]->getData() != null) {
                //Initialisation de l'input de la date
                $date = $task->getLimitedate()->format("Y-m-d");
                $d = \DateTime::createFromFormat("Y-m-d", $date);
                $editForm->get('date')->setData($d->format('d-m-Y'));

                //Initialisation de l'input de l'heure
                $time = $task->getLimitedate()->format("H:i");
                $t = \DateTime::createFromFormat("H:i", $time);
                $editForm->get('time')->setData($t->format('H:i'));
            }
            else{
                //Initialisation de l'input de la date
                $d = date("m-d-Y");
                $editForm->get('date')->setData($d);
            }
        }

        return $this->render('task/edit.html.twig', array(
            'task' => $task,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page' => $page,
        ));
    }

    /**
     * Deletes a task entity.
     *
     * @Route("/{idtask}", name="task_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Task $task)
    {
        $form = $this->createDeleteForm($task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        }

        return $this->redirectToRoute('task_index');
    }

    /**
     * Creates a form to delete a task entity.
     *
     * @param Task $task The task entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Task $task)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_delete', array('idtask' => $task->getIdtask())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Close a task.
     *
     * @Route("/{idtask}/close", name="task_close")
     * @Method({"GET"})
     */
    public function clotureAction(Task $task){
        $em = $this->getDoctrine()->getManager();

        $task->setEnddate(new \DateTime("now"));
        $em->flush();

        return $this->redirectToRoute('task_index');

    }
}
