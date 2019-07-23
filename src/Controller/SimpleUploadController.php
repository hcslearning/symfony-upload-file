<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class SimpleUploadController extends AbstractController
{
    
    /**
     * @Route("/simple/upload", name="simple_upload")
     */
    public function index( Request $request )
    {
        $form = $this->createForm(\App\Form\ImageType::class);
        $form->handleRequest($request);
        
        $descripcion    = $descripcion = $form['descripcion']->getData();
        // procesa el formulario con el archivo
        $imagen         = $this->procesarForm($form, $request);
        
        // envía el formulario al template
        return $this->render('simple_upload/index.html.twig', [
            'form'          => $form->createView()
            ,'imagen'       => $imagen
            ,'descripcion'  => $descripcion
        ]);
    }
    
    private function procesarForm(FormInterface $form, Request $request) {
        if($form->isSubmitted() && $form->isValid()) {
            // se usa var para decirle a NB el tipo
            /* @var $imageFile UploadedFile */
            $imageFile   = $form['imagen']->getData();
            
            if($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename     = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename      = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try {
                    $dir = $this->getParameter('project_dir').'/public/images/';
                    $imageFile->move($dir, $newFilename);
                    return $newFilename;
                } catch (FileException $e) {
                    throw $e;
                }
            }
            
        }
    }
    
}
