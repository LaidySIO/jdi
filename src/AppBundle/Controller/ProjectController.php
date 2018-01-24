<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Priority;
use AppBundle\Entity\Project;
use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Project controller.
 *
 * @Route("/project")
 */
class ProjectController extends Controller
{
    /**
     * Lists all project entities.
     *
     * @Route("/", name="project_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$projects = $em->getRepository('AppBundle:Project')->findAll();
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $projects = $em->getRepository('AppBundle:Project')->findAll();
        }
        else{
            $query = $em->createQuery(
                'SELECT p
            FROM AppBundle:User u, AppBundle:Project p
            WHERE u.id = p.master
            AND p.master = :user
            OR p.idproject IN(
            SELECT IDENTITY(pu.idproject) 
            FROM AppBundle:Project_User pu
            WHERE pu.user_id = :user
            )
            ORDER BY p.limitedate ASC'
            )->setParameter('user', $this->getUser());

            $projects = $query->getResult();
        }
        $query = $em->createQuery( // Liste des priorités
            'SELECT pr
            FROM AppBundle:Priority pr, AppBundle:Project p
            WHERE pr.idpriority = p.priorityid
            ORDER BY pr.code ASC'
        );

        $priorities = $query->getResult();

        $page = "index";

        return $this->render(
            'project/index.html.twig',
            array(
                'projects' => $projects,
                'priorities' => $priorities,
                'page' => $page,
            )
        );

    }


    /**
     * Creates a new project entity.
     *
     * @Route("/new", name="project_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm('AppBundle\Form\ProjectType', $project);
        $form->handleRequest($request);
        $page = "new";


        if ($form->isSubmitted() && $form->isValid()) {
            // Affectation de la valeur du champs limitedate
            if ($form["is_date"]->getData() == 1) { // Si checkbox de la date cochée
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
                $dateTime = \DateTime::createFromFormat("Y-m-d H:i:s",$timestramp);
                $project->setLimitedate($dateTime);
            }
            else{ // Si date de fin non définie
                $project->setLimitedate(null);
            }

            $em = $this->getDoctrine()->getManager();
            $project->setCreationDate(new \DateTime());
            $project->setMaster($this->getUser());
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('project_show', array('idproject' => $project->getIdproject()));
        }

        else{
            //Initialisation de l'input de la date
            $d = date("m-d-Y");
            $form->get('date')->setData($d);

            //Initialisation de l'input de l'heure
            /*$t = date("H:i");
            $form->get('time')->setData($t);*/
        }


        return $this->render('project/new.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
            'page' => $page,
        ));
    }

    /**
     * Finds and displays a project entity.
     *
     * @Route("/{idproject}", name="project_show")
     * @Method("GET")
     */
    public function showAction(Project $project)
    {
        $deleteForm = $this->createDeleteForm($project);

        $repository = $this->getDoctrine()->getRepository(Task::class);
        $page = "show";


        $tasks =  $repository->findBy(
            ['projectmaster' => $project->getIdproject()]
        );

        // return var_dump($project);

        return $this->render('project/show.html.twig', array(
            'project' => $project,
            'task' => $tasks,
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing project entity.
     *
     * @Route("/{idproject}/edit", name="project_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Project $project)
    {
        $deleteForm = $this->createDeleteForm($project);
        $editForm = $this->createForm('AppBundle\Form\ProjectType', $project);
        $editForm->handleRequest($request);
        $page = "edit";

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Affectation de la valeur du champs limitedate
            if ($editForm["is_date"]->getData() == 1){ // Si checkbox de la date cochée
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
                $project->setLimitedate($dateTime);
            }
            else{ // Si date de fin non définie
                $project->setLimitedate(NULL);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_edit', array('idproject' => $project->getIdproject()));
        }
        else{
            if( $editForm["date"]->getData() != null){
                //Initialisation de l'input de la date
                $date = $project->getLimitedate()->format("Y-m-d");
                $d = \DateTime::createFromFormat("Y-m-d",$date);
                $editForm->get('date')->setData($d->format('d-m-Y'));

                //Initialisation de l'input de l'heure
                $time = $project->getLimitedate()->format("H:i");
                $t = \DateTime::createFromFormat("H:i",$time);
                $editForm->get('time')->setData($t->format('H:i'));
            }
            else{
                //Initialisation de l'input de la date
                $d = date("m-d-Y");
                $editForm->get('date')->setData($d);
            }


        }

        return $this->render('project/edit.html.twig', array(
            'project' => $project,
            'edit_form' => $editForm->createView(),
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a project entity.
     *
     * @Route("/{idproject}", name="project_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Project $project)
    {
        $form = $this->createDeleteForm($project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
        }

        return $this->redirectToRoute('project_index');
    }

    /**
     * Creates a form to delete a project entity.
     *
     * @param Project $project The project entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Project $project)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('idproject' => $project->getIdproject())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Close a project.
     *
     * @Route("/{idproject}/close", name="project_close")
     * @Method({"GET"})
     */
    public function clotureAction(Project $project){
        $em = $this->getDoctrine()->getManager();

        $project->setEnddate(new \DateTime("now"));
        $em->flush();

        return $this->redirectToRoute('project_index');

    }

}
