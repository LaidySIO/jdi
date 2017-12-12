<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
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
            ->add('projectmaster')
            ->add('fosUser');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_task';
    }


}
