<?php

namespace App\Menu\Vacancy;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class VacancySettingsMenu
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function build(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttributes(['class' => 'nav nav-tabs ']);

        $menu->addChild('Common', [
            'route' => 'vacancy.show',
            'routeParameters' => ['id' => $options['vacancy_id']]
        ])
        ->setExtra('routes', [
            ['route' => 'vacancy.show'],
            ['pattern' => '/^vacancy.show\..+/']
        ])
        ->setAttribute('class', 'nav-item')
        ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Edit', [
            'route' => 'vacancy.edit',
            'routeParameters' => ['id' => $options['vacancy_id']]
        ])
        ->setExtra('routes', [
            ['route' => 'vacancy.edit'],
            ['pattern' => '/^vacancy.edit\..+/']
        ])
        ->setAttribute('class', 'nav-item')
        ->setLinkAttribute('class', 'nav-link');

        $menu->addChild('Person', [
            'route' => 'vacancy.list.persons',
            'routeParameters' => ['id' => $options['vacancy_id']]
        ])
        ->setExtra('routes', [
            ['route' => 'vacancy.list.persons'],
            ['pattern' => '/^vacancy.list.persons\..+/']
        ])
        ->setAttribute('class', 'nav-item')
        ->setLinkAttribute('class', 'nav-link');

        return $menu;
    }
}
