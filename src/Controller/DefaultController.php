<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Upload;
use App\Form\UploadType;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends AbstractController
{
    /**
     * @Route("/upload", name="upload")
     */
    public function upload()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }


    /**
     * @Route("/", name="Homepage")
     */
    public function index(Request $request,\Swift_Mailer $mailer){
        $upload = new Upload();
        $form = $this-> createForm(UploadType::class, $upload);

        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form->isValid()){
            $today = date('Y-m-d');
			// recuperation des données de la form
	        $data 				 = $form->getData();
	        $name 				 = $data->getName();
	        $firstname 			 = $data->getFirstName();
	        $email 				 = $data->getEmail();
	        $phone 				 = $data->getMobile();
	        $buildingBatiment 	 = $data->getBuilding();
	        $office 			 = $data->getOffice();
	        $uploadFile          = $data->getfile();
	        $DeleveryDate 		 = $data->getDeliveryDate();
	        $printingFormat 	 = $data->getPrintingFormat();
			$comment			 = $data->getComment();
			//Récupération et paramétrage du fichier
			$file = $upload->getFile();
			$filename = $DeleveryDate->format('Y-m-d') . "_" . $firstname . "_" . $name . "_" . $file->getClientOriginalName();
            $file->move($this->getParameter('upload_directory'),$filename);
            $upload->setFile($filename);

            
	        // vérification du printing format pour voir si on utilise un format déjà créer ou un custom 
	        if($printingFormat !=3)
	        {
	        	$printingFormat = $printingFormat;
	       	}
	       	else
	       	{
	             $printingFormat = sprintf("%s x %s", $customFormat1, $customFormat2);
	        }     

	        // forme de l'email envoyé au demandeur du poster
	      	$confirmationEmail = '%s %s,
	      
Your poster printing request has been taken into account.
Votre demande d’impression du poster a bien été pris en compte.

	      	Nom : %s
	      	Prenom : %s
	      	Email : %s
	      	Telephone : %s
	      	Batiment %s
	      	Office : %s
			Format : %s
			comment: %s';

	      	$titleFormat = '%s_%s_%s.%s';
			
	      	$file = sprintf($titleFormat, $today, $name, $firstname, $uploadFile);
	      	
			$body = sprintf($confirmationEmail, $name, $firstname, $name, $firstname, $email, $phone, $buildingBatiment, $office, $printingFormat,$comment);


			// Message pour le créateur de la demande, avec son sujet
			// les mails sont configurés dans "config/packages/swiftmailer.yaml" et dans le dossier ".env"
			$message = (new \Swift_Message('[GeePs Posters] poster printing request – Demande d’impression poster'))

  			// qui envoie l'email
  			->setFrom($email)

  			// qui recois l'email
  			->setTo($email)

  			// le corps du mail créer plus haut
  			->setBody($body);

			// envoie de l'email
  			$mailer->send($message);

			// forme de l'email a geeps
			$geepsEmail = 'Le %s,
%s %s demande l’impression de son poster %s.

	      	Nom : %s
	      	Prenom : %s
	      	Email : %s
	      	Telephone : %s
	      	Batiment %s
	      	Office : %s
			  Format : %s
			  comment: %s';


			$body = sprintf($geepsEmail, $today, $name, $firstname, $filename, $name, $firstname, $email, $phone, $buildingBatiment, $office, $printingFormat,$comment);

  			//Message addressé au Geeps, avec son sujet
  			$message = (new \Swift_Message('[GeePs Posters] Demande d’impression poster'))

			// qui envoie l'email
  			->setFrom("poster@geeps.centralesupelec.fr") //

  			// qui recois l'email
  			->setTo("asr@geeps.centralesupelec.fr") //

  			// le corps du mail créer plus haut
  			->setBody($body);

			// envoie de l'email
  			$mailer->send($message);
	      
	      	// message pop up
  			$this->addFlash('success', sprintf("An email as been sending to '%s' and to '%s' your request has been taken into account", $email, $email));
  
            return $this->redirectToRoute('Homepage');
        }


        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
    ));
    }

}

