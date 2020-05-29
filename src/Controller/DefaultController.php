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
    public function index(Request $request){
        $upload = new Upload();
        $form = $this-> createForm(UploadType::class, $upload);

        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form->isValid()){
            $file = $upload->getFile();
            $filename = $file->getClientOriginalName();
            $file->move($this->getParameter('upload_directory'),$filename);
            $upload->setFile($filename);

            return $this->redirectToRoute('Homepage');
        }

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
    ));
    }

}

