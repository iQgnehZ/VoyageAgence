<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Circuit;
use AppBundle\Entity\Commentaire;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Circuit controller.
 */
class CircuitController extends Controller
{
    /**
     * Lists all Circuit entities.
     * @Route("/", name="homepage")
     * @Route("/circuit/", name="circuit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $circuits = $em->getRepository('AppBundle:Circuit')->findAll();

        return $this->render('circuit/index.html.twig', array(
            'circuits' => $circuits
        ));
    }

    /**
     * Finds and displays a Circuit entity.
     *
     * @Route("/circuit/{id}", name="circuit_show", requirements={
	 *              "id": "\d+"
	 *     })
     */
    public function showAction(Circuit $circuit, Request $request)
    {
    	$commentaire = new Commentaire();
    	$form = $this->createFormBuilder($commentaire)
    	->add('user_name', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
    	->add('description', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
     	->add('save', SubmitType::class, array('label'=>'Create Circuit','attr' => array('class' =>'btn btn_primary','style' =>'margin-bottom:15px')))
    	->getForm();
    	$form->handleRequest($request);
    	
    	
    	if($form->isSubmitted() && $form->isValid()){
    		$userName = $form['user_name']->getData();
    		$description = $form['description']->getData();
    		   
    		$commentaire->setDescription($description);
    		$commentaire->setUserName($userName);
      	
    		$circuit->addCommentaire($commentaire);
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($commentaire);
    		$em->persist($circuit);
    		$em->flush();
    	
    		$this->addFlash('notice','Commentaire Added');
    	
    		return $this->redirectToRoute('circuit_show',array('id' => $circuit->getId()));
    	}
    	
    	return $this->render('circuit/show.html.twig', array(
            'circuit' => $circuit,'form' => $form->createView()
        ));
    }

}
