<?php


namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class AperitifAdmin
 * @package App\Admin
 */
class AperitifAdmin extends AbstractAdmin
{
    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
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
            ->add('comment')
            ->add('_action', null,[
                'actions' => [
                    'delete' => [],
                ]
            ])
        ;
    }

}