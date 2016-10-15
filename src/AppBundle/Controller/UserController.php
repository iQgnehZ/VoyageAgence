<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Circuit;
use AppBundle\Entity\Etape;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\ProgrammationCircuit;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * User controller.
 */
class UserController extends Controller
{
	/**
	 * @Route("/admin/circuits/", name="default_security_target")
	 * @Route("/admin/circuits/list", name="circuits_list")
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
	 * @Route("/admin/circuit/details/{id}", name="circuit_details", requirements={
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
	 * @Route("/admin/circuit/delete/{id}", name="circuit_delete" )
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
	 * @Route("/admin/circuit/create", name="circuit_create")
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
	 * @Route("/admin/circuit/edit/{id}", name="circuit_edit" )
	 */
	public function editAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$circuit=$em->getRepository('AppBundle:Circuit')->find($id);
		
		$circuit->setDescription($circuit->getDescription());
		$circuit->setDureeCircuit($circuit->getdureeCircuit());
		$circuit->setPaysDepart($circuit->getpaysDepart());
		$circuit->setVilleArrivee($circuit->getvilleArrivee());
		$circuit->setVilleDepart($circuit->getvilleDepart());
		
		$form = $this->createFormBuilder($circuit)
		->add('pays_depart', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('ville_depart', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('ville_arrivee', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('duree_circuit', IntegerType::class, array('attr' => array('class' =>'formcontrol','style' =>'margin-bottom:15px')))
		->add('description', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('save', SubmitType::class, array('label'=>'Update Circuit','attr' => array('class' =>'btn btn_primary','style' =>'margin-bottom:15px')))
		->getForm();
		
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			$paysDepart = $form['pays_depart']->getData();
			$villeDepart = $form['ville_depart']->getData();
			$villeArrivee = $form['ville_arrivee']->getData();
			$dureeCircuit = $form['duree_circuit']->getData();
			$description = $form['description']->getData();
				
			$em = $this->getDoctrine()->getManager();
			$circuit = $em->getRepository('AppBundle:Circuit')->find($id);
				
			$circuit->setDescription($description);
			$circuit->setDureeCircuit($dureeCircuit);
			$circuit->setPaysDepart($paysDepart);
			$circuit->setVilleArrivee($villeArrivee);
			$circuit->setVilleDepart($villeDepart);
				
			$em->persist($circuit);
			$em->flush();
			$this->addFlash(
					'notice',
					'Circuit Updated'
					);
		
			return $this->redirectToRoute('circuits_list');
		}
		
		return $this->render('user/edit.html.twig', array(
				'circuit' => $circuit,
				'form' => $form->createView()
		
		));
		 
	}
	/**
	 * @Route("/admin/circuit/etape/delete/{circuit_id}/{id}", name="etape_delete" )
	 */
	public function deleteEtapeAction($circuit_id,$id)
	{
		$em = $this->getDoctrine()->getManager();
		$circuit=$em->getRepository ( 'AppBundle:Circuit' )->find ( $circuit_id );
		$etape = $em->getRepository ( 'AppBundle:Etape' )->find ( $id );
		
		$circuit->removeEtape ( $etape );
		$em->remove ( $etape );
		$em->flush ();
		
		$this->addFlash ( 'notice', 'Etape Removed' );
		
		return $this->redirectToRoute ( 'circuit_details', array (
				'id' => $circuit_id 
		) );
	}
	/**
	 * @Route("/admin/circuit/etape/create/{circuit_id}", name="etape_create")
	 */
	public function createEtapeAction($circuit_id, Request $request) 
	{
		$circuit = $this->getDoctrine ()->getRepository ( 'AppBundle:Circuit' )->find ( $circuit_id );
		
		$etape = new Etape ();
		
		$form = $this->createFormBuilder($etape)
		->add('numero_etape', IntegerType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('ville_etape', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('nombre_jours', IntegerType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('save', SubmitType::class, array('label'=>'Create Etape','attr' => array('class' =>'btn btn_primary','style' =>'margin-bottom:15px')))
		->getForm();
		
			$form->handleRequest($request);
		
			if($form->isSubmitted()&& $form->isValid()){
				$etape=$form->getData();
				$circuit->addEtape($etape);
		
				$em = $this->getDoctrine()->getManager();
				$em->persist($etape);
				$em->persist($circuit);
				$em->flush();
		
				$this->addFlash(
						'notice',
						'Etape Added'
						);
				return $this->redirectToRoute('circuit_details',array('id' => $circuit_id));
			}
		
			return $this->render('user/createEtape.html.twig', array(
					'form' => $form->createView(),
			));
	}
	/**
	 * @Route("/admin/circuit/etape/edit/{circuit_id}/{id}", name="etape_edit" )
	 */
	public function editEtapeAction($circuit_id, $id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();	
	    $etape=$em->getRepository('AppBundle:Etape')->find($id);
	    $circuit=$em->getRepository('AppBundle:Circuit')->find($circuit_id);
	    $circuit->BeforeUpdateEtape($etape);
		$etape->setNumeroEtape($etape->getNumeroEtape());
		$etape->setVilleEtape($etape->getVilleEtape());
		$etape->setNombreJours($etape->getNombreJours());
	
		$form = $this->createFormBuilder($etape)
		->add('numero_etape', IntegerType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('ville_etape', TextType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('nombre_jours', IntegerType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('save', SubmitType::class, array('label'=>'Update Etape','attr' => array('class' =>'btn btn_primary','style' =>'margin-bottom:15px')))
		->getForm();
	
		$form->handleRequest($request);
	
		if($form->isSubmitted() && $form->isValid()){
			$numeroEtape = $form['numero_etape']->getData();
			$villeEtape = $form['ville_etape']->getData();
			$nombreJours = $form['nombre_jours']->getData();
			
			$em = $this->getDoctrine()->getManager();
			$etape = $em->getRepository('AppBundle:Etape')->find($id);
	       
			$etape->setNumeroEtape($numeroEtape);
			$etape->setVilleEtape($villeEtape);
			$etape->setNombreJours($nombreJours);
			$circuit=$em->getRepository('AppBundle:Circuit')->find($circuit_id);
			$circuit->AfterUpdateEtape($etape);
			$em->persist($etape);
			$em->persist($circuit);
			$em->flush();
			$this->addFlash(
					'notice',
					'Etape Updated'
					);
	
			return $this->redirectToRoute('circuit_details',array('id' => $circuit_id));
		}
	
		return $this->render('user/editEtape.html.twig', array(
				'$ciruit' => $circuit,
				'form' => $form->createView()
	
		));	
	}
	/**
	 * @Route("/admin/circuit/programmation/delete/{circuit_id}/{id}", name="prog_delete" )
	 */
	public function deleteProgrammationAction($circuit_id,$id)
	{
		$em = $this->getDoctrine()->getManager();
		$circuit=$em->getRepository ( 'AppBundle:Circuit' )->find ( $circuit_id );
		$prog = $em->getRepository ( 'AppBundle:ProgrammationCircuit' )->find ( $id );
	
		$circuit->removeProgrammation($prog);
		$em->remove( $prog );
		$em->flush ();
	
		$this->addFlash ( 'notice', 'Programmation Removed' );
	
		return $this->redirectToRoute ( 'circuit_details', array (
				'id' => $circuit_id
		) );
	}
	/**
	 * @Route("/admin/circuit/prog/create/{circuit_id}", name="prog_create")
	 */
	public function createProgrammationAction($circuit_id, Request $request)
	{
		$circuit = $this->getDoctrine ()->getRepository ( 'AppBundle:Circuit' )->find ( $circuit_id );
	
		$prog = new ProgrammationCircuit();
	
		$form = $this->createFormBuilder($prog)
		->add('date_depart', DateTimeType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('nombre_personnes', IntegerType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('prix', IntegerType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('save', SubmitType::class, array('label'=>'Create Programmation','attr' => array('class' =>'btn btn_primary','style' =>'margin-bottom:15px')))
		->getForm();
	
		$form->handleRequest($request);
	
		if($form->isSubmitted()&& $form->isValid()){
			$prog=$form->getData();
			$circuit->addProgrammation($prog);
	
			$em = $this->getDoctrine()->getManager();
			$em->persist($prog);
			$em->persist($circuit);
			$em->flush();
	
			$this->addFlash(
					'notice',
					'Programmation Added'
					);
			return $this->redirectToRoute('circuit_details',array('id' => $circuit_id));
		}
	
		return $this->render('user/createProgrammation.html.twig', array(
				'form' => $form->createView(),
		));
	}
	/**
	 * @Route("/admin/circuit/prog/edit/{circuit_id}/{id}", name="prog_edit" )
	 */
	public function editProgrammationAction($circuit_id, $id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$prog=$em->getRepository('AppBundle:ProgrammationCircuit')->find($id);
		$circuit=$em->getRepository('AppBundle:Circuit')->find($circuit_id);
		
		$prog->setDateDepart($prog->getDateDepart());
		$prog->setNombrePersonnes($prog->getNombrePersonnes());
		$prog->setPrix($prog->getPrix());
	
		$form = $this->createFormBuilder($prog)
		->add('date_depart', DateTimeType::class, array('widget'=>'single_text','attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('nombre_personnes', IntegerType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('prix', IntegerType::class, array('attr' => array('class' =>'form-control','style' =>'margin-bottom:15px')))
		->add('save', SubmitType::class, array('label'=>'Update Programmation','attr' => array('class' =>'btn btn_primary','style' =>'margin-bottom:15px')))
		->getForm();
	
		$form->handleRequest($request);
	
		if($form->isSubmitted() && $form->isValid()){
			$dateDepart = $form['date_depart']->getData();
			$nombrePersonnes = $form['nombre_personnes']->getData();
			$prix = $form['prix']->getData();
				
			$em = $this->getDoctrine()->getManager();
			$prog = $em->getRepository('AppBundle:ProgrammationCircuit')->find($id);
	
			$prog->setDateDepart($dateDepart);
			$prog->setNombrePersonnes($nombrePersonnes);
			$prog->setPrix($prix);
			
			$circuit=$em->getRepository('AppBundle:Circuit')->find($circuit_id);
			
			$em->persist($prog);
			$em->persist($circuit);
			$em->flush();
			$this->addFlash(
					'notice',
					'Programmation Updated'
					);
	
			return $this->redirectToRoute('circuit_details',array('id' => $circuit_id));
		}
	
		return $this->render('user/editProgrammation.html.twig', array(
				'$ciruit' => $circuit,
				'form' => $form->createView()
	
		));
	}
	
}
