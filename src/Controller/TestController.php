<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UploadTest;
use App\Form\UploadTestType;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(Request $request)
    {
        $upload = new UploadTest();
        $form = $this-> createForm(UploadTestType::class, $upload);

        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form->isValid()){
            $file = $upload->getFile();
            $filename = $file->getClientOriginalName();
            $file->move($this->getParameter('upload_directory'),$filename);
            $upload->setFile($filename);

            return $this->redirectToRoute('test');
        }

        return $this->render('test/index.html.twig', array(
            'form' => $form->createView(),
    ));
    }

}
