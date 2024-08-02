<?php

namespace App\Form;

use App\Entity\Vacancy;
use App\Entity\VacancyResume;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $allowedVacancies = $options['allowed_vacancies'];
        $builder
            ->add('vacancy', EntityType::class, [
                'class' => Vacancy::class,
                'required' => true,
                'choices' => $allowedVacancies,
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'trim' => false,
            ])
            ->add('reset', ResetType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VacancyResume::class,
            'allowed_vacancies' => null,
        ]);
    }
}
