<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class LinkRegistrationAdmin
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class LinkRegistrationAdmin extends AbstractAdmin
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
            ->addIdentifier('email', null, [
                'route' => [
                    'name' => 'show',
                ],
            ])
            ->add('createdAt')
            ->add('createdBy')
        ;
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('email')
            ->add('selector')
            ->add('token_registration')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }
}