<?php

namespace App\Model\Person\UseCase\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', Type\TextType::class, ['label' => 'First Name'])
            ->add('lastName', Type\TextType::class, ['label' => 'Last Name'])
            ->add('jobTitle', Type\TextType::class, [ 'required' => false,'label' => 'Job Title'])
            ->add('email', Type\EmailType::class, [ 'required' => false,'label' => 'Email'])
            ->add('phone', Type\TelType::class, [ 'required' => false,'label' => 'Phone']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
