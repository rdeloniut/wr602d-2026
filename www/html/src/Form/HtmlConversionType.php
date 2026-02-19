<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class HtmlConversionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Fichier HTML',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un fichier HTML']),
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => ['text/html'],
                        'mimeTypesMessage' => 'Veuillez uploader un fichier HTML valide (.html)',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Convertir en PDF',
            ]);
    }
}
