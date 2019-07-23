<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('descripcion', TextType::class, ['mapped' => false, 'required' => false])
                ->add('imagen', FileType::class, [
                    'label' => 'Imagen (jpg, jpeg, png)'
                    , 'mapped' => false
                    , 'required' => true
                    , 'constraints' => [
                        new \Symfony\Component\Validator\Constraints\File([
                            'maxSize' => '1024k'
                            , 'mimeTypes' => [
                                'image/jpeg'
                                , 'image/png'
                            ], 'mimeTypesMessage' => 'Por favor suba una imagen válida'
                                ])
                    ]
                ])
                ->add('submit', SubmitType::class, ['label' => 'Upload'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
                // Configure your form options here
        ]);
    }

}
