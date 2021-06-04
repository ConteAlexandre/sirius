<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserFixtures
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UserFixtures extends AbstractFixtures
{
    const NUMBER_USER = 15;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function loadUser(ObjectManager $manager)
    {
        for ($i = 0; $i < self::NUMBER_USER; $i++) {
            $data = [
                'username' => $this->faker->userName,
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'company' => $this->faker->company,
                'company_activity' => $this->getReference($this->faker->randomElement(array_keys(CompanyActivityFixtures::COMPANY_ACTIVITY))),
                'email' => $this->faker->email,
                'phone_number' => $this->faker->phoneNumber,
                'beverage' => $this->faker->name,
                'salt' => $this->faker->text,
                'enabled' => true,
            ];
            $user = new User();
            $user
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->passwordEncoder->encodePassword($user, 'michel'));

            foreach ($data as $prop => $value) {
                $this->propertyAccessor->setValue($user, $prop, $value);
            }

            $manager->persist($user);
        }
    }


}