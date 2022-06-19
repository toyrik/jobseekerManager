<?php

namespace App\Model\Person\UseCase\Network\Attach;

use App\Model\Person\Entity\Person\Network;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('network', Type\ChoiceType::class, ['choices' =>[
                'VK' => Network::VK,
                'Habr' => Network::HABR,
                'Telegramm' => Network::TELEGRAM,
            ]])
            ->add('identity', Type\TextType::class, ['label' => 'Identity']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }

    public function getBlockPrefix(): string
    {
        return 'network';
    }
}
