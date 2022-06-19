<?php

namespace App\Model\Vacancy\UseCase\Membership\Add;

use App\ReadModel\Person\PersonFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $persons;

    public function __construct(PersonFetcher $persons)
    {
        $this->persons = $persons;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $persons = [];
        foreach ($this->persons->listIds() as $item) {
            $persons[$item['name']] = $item['id'];
        }

        $builder
            ->add('person', Type\ChoiceType::class, [
                'choices' => $persons,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['vacancy']);
    }
}
