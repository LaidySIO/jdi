<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $projects = $em->getRepository('AppBundle:Project')->findAll();
        $tasks = $em->getRepository('AppBundle:Task')->findAll();
        $messages = $em->getRepository('AppBundle:Message')->findAll();
        $page = "homepage";

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'projects' => $projects,
            'tasks' => $tasks,
            'messages' => $messages,
            'page' => $page,
        ]);
    }
}
