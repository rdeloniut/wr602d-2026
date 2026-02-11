<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class MarkdownConversionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Fichier Markdown',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un fichier Markdown']),
                    new File([
                        'maxSize' => '10M',
                        'extensions' => ['md', 'markdown'],
                        'extensionsMessage' => 'Veuillez uploader un fichier Markdown valide (.md)',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Convertir en PDF',
            ]);
    }
}
