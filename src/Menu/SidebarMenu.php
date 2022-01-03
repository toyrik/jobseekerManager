<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class SidebarMenu
{
    private FactoryInterface $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function build(): ItemInterface
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttributes(['class'=>'nav nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview', 'role' => 'menu', 'data-accordion' => 'false']);

        $menu->addChild('Vacancies', ['route' => 'vacancies'])
            ->setExtra('icon', 'fas fa-briefcase')
            ->setExtra('routes', [
                ['route' => 'vacancies'],
                ['pattern' => '/^vacancies\..+/']
            ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        return $menu;
    }
}
