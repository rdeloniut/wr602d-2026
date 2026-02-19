<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class ScreenshotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', UrlType::class, [
                'label' => 'URL à capturer',
                'attr' => [
                    'placeholder' => 'https://www.example.com',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer une URL']),
                    new Url(['message' => 'Veuillez entrer une URL valide']),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Capturer la page',
            ]);
    }
}
