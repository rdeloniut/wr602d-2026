<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class OfficeConversionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Document Office',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un document Office']),
                    new File([
                        'maxSize' => '50M',
                        'mimeTypes' => [
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/vnd.oasis.opendocument.text',
                            'application/vnd.oasis.opendocument.spreadsheet',
                            'application/vnd.oasis.opendocument.presentation',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un document Office valide (Word, Excel, PowerPoint, ODT, ODS, ODP)',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Convertir en PDF',
            ]);
    }
}
