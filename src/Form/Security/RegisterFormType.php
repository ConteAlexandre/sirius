<?php

namespace App\Form\Security;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegisterFormType
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class RegisterFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('company', TextType::class)
            ->add('beverage', TextType::class)
            ->add('password', RepeatedType::class, [
                'property_path' => 'plainPassword',
                'first_options' => 'Password',
                'second_options' => 'Confirm Password',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ])
        ;
    }
}