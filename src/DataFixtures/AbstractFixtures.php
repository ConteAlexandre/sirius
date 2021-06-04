<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AbstractFixtures
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
abstract class AbstractFixtures extends Fixture
{
    /**
     * @var Generator
     */
    protected $faker;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * AbstractFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->passwordEncoder = $userPasswordEncoder;
        $this->faker = Factory::create();
        $this->propertyAccessor = new PropertyAccessor();
    }
}