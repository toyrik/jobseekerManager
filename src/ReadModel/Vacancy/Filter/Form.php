<?php

namespace App\ReadModel\Vacancy\Filter;

use App\Model\Vacancy\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Title',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'New' => Status::NEW,
                'Active' => Status::ACTIVE,
                'Archived' => Status::ARCHIVE,
            ], 'required' => false, 'placeholder' => 'All statuses', 'attr' => ['onchange' => 'this.form.submit()']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

}
