<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class SkillAdmin
 * @package App\Admin
 */
class SkillAdmin extends AbstractAdmin
{
    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('edit')
        ;
    }
    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->add('name')
            ->add('users')
            ->add('createdAt')
            ->add('createdBy')
            ->add('_action', null,[
                'actions' => [
                    'delete' => [],
                ]
            ])
        ;
    }
    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('id')
            ->add("name")
            ->add('users')
            ->add('createdAt')
            ->add('createdBy')
        ;
    }
}