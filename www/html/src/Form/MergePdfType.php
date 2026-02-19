<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class MergePdfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('files', FileType::class, [
                'label' => 'Fichiers PDF à fusionner',
                'multiple' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner au moins 2 fichiers PDF']),
                    new Count([
                        'min' => 2,
                        'minMessage' => 'Veuillez sélectionner au moins {{ limit }} fichiers PDF',
                    ]),
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '50M',
                                'mimeTypes' => ['application/pdf'],
                                'mimeTypesMessage' => 'Chaque fichier doit être un PDF valide',
                            ]),
                        ],
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Fusionner les PDF',
            ]);
    }
}
