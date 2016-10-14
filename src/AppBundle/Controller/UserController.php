<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Circuit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * User controller.
 */
class UserController extends Controller
{
	/**
	 * @Route("/circuits/list", name="circuits_list")
	 * @Method("GET")
	 */
	public function listAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		
		$circuits = $em->getRepository('AppBundle:Circuit')->findAll();
		
		return $this->render('user/circuits.html.twig', array(
				'circuits' => $circuits,
		));
	}
	/**
	 * Finds and displays a Circuit entity.
	 *
	 * @Route("/circuit/details/{id}", name="circuit_details", requirements={
	 *              "id": "\d+"
	 *     })
	 * @Method("GET")
	 */
	public function detalisAction(Circuit $circuit)
	{
		return $this->render('user/details.html.twig', array(
				'circuit' => $circuit,
		));
	}
	/**
	 * @Route("/circuit/delete/{id}", name="circuit_delete" )
	 */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$circuit=$em->getRepository('AppBundle:Circuit')->find($id);
	    
		$em->remove($circuit);
		$em->flush();
	
		$this->addFlash(
				'notice',
				'Circuit Removed'
				);
	
		return $this->redirectToRoute('circuits_list');
	}
	/**
	 * @Route("/circuit/create", name="circuit_create")
	 */
	public function createAction(Request $request)
	{
		$circuit = new Circuit;
		$form = $this->createFormBuilder($circuit)
		->add('pays_depart', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('ville_depart', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('ville_arrivee', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('duree_circuit', IntegerType::class, array('attr' => array('class' =>'formcontrol','style' =>'margin-bottom:15px')))
		->add('description', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('save', SubmitType::class, array('label'=>'Create Circuit','attr' => array('class' =>'btn btn_primary','style' =>'margin-bottom:15px')))
		->getForm();
		$form->handleRequest($request);
		
		
		if($form->isSubmitted() && $form->isValid()){
			$paysDepart = $form['pays_depart']->getData();
			$villeDepart = $form['ville_depart']->getData();
			$villeArrivee = $form['ville_arrivee']->getData();
			$description = $form['description']->getData();
			$dureeCircuit = $form['duree_circuit']->getData();
				
			$circuit->setDescription($description);
			$circuit->setDureeCircuit($dureeCircuit);
			$circuit->setPaysDepart($paysDepart);
			$circuit->setVilleArrivee($villeArrivee);
			$circuit->setVilleDepart($villeDepart);
				
			$em = $this->getDoctrine()->getManager();
			$em->persist($circuit);
			$em->flush();
				
			$this->addFlash('notice','Circuit Added');
				
			return $this->redirectToRoute('circuits_list');
		}
		return $this->render('user/create.html.twig',array(
				'form'=> $form->createView()
		));
	}
	/**
	 * @Route("/circuit/edit/{id}", name="circuit_edit )
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$circuit=$em->getRepository('AppBundle:Circuit')->find($id);
		 
	}
}
