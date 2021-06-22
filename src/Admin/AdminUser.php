<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class AdminUser
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AdminUser extends AbstractAdmin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('company')
            ->add('company')
            ->add('companyActivity')
            ->add('email')
            ->add('phoneNumber')
            ->add('beverage')
            ->add('plainPassword')
            ->add('skills')
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('username', null, [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->add('email')
            ->add('createdAt')
            ->add('createdBy')
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('username')
            ->add('email')
        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('company')
            ->add('company')
            ->add('companyActivity')
            ->add('email')
            ->add('phoneNumber')
            ->add('beverage')
            ->add('plainPassword')
            ->add('skills')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }
}