<?php

namespace App\Form;

use App\Entity\Vacancy;
use App\Entity\VacancyResume;
use App\Entity\VacancyResumeMark;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResumeMarkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mark', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    1, 2, 3, 4, 5
                ],
                'choice_label' => function ($choice) {
                    return $choice;
                },
            ])
            ->add('reset', ResetType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VacancyResumeMark::class,
        ]);
    }
}
