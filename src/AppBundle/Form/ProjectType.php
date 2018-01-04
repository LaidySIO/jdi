<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('is_date', CheckboxType::class, array(
                'label' => 'Définir une une date',
                'mapped' => false,
                'required' => false,
                'attr' => array(
                    'class' => 'is_date',
                    'id' => 'is_date'
                )
            ))
            ->add('date', TextType::class, array(
                'label' => 'Date Limite',
                'mapped' => false,
                'required' => 'required',
                'attr' => array(
                    'class' => 'datepicker',
                    'id' => 'datepicker',
                    'placeholder' => 'Date'
                )
            ))
            ->add('is_time', CheckboxType::class, array(
                'label' => 'Définir une heure',
                'mapped' => false,
                'required' => false,
                'attr' => array(
                    'class' => 'is_time',
                    'id' => 'is_time'
                )
            ))
            ->add('time', TextType::class, array(
                'label' => false,
                'mapped' => false,
                'required' => false,
                'attr' => array(
                    'class' => 'timepicker',
                    'id' => 'timepicker',
                    'placeholder' => 'Heure'
                )
            ))
            ->add('priorityid')
            ->add('details', TextareaType::class, array(
                'label' => 'Informations complémentaires',
                'required' => false,
                'attr' => array(
                    'class' => 'details',
                    'style' => 'width:250px;height:250px'
                )
            ))
            ->add('fosUser');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Project'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_project';
    }


}
