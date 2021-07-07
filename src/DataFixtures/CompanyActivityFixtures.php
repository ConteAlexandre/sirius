<?php

namespace App\DataFixtures;

use App\Entity\CompanyActivity;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CompanyActivityFixtures
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class CompanyActivityFixtures extends AbstractFixtures
{
    const COMPANY_ACTIVITY_ARCHITECTURE = 'company_activity_architecture';
    const COMPANY_ACTIVITY_INFORMATICS = 'company_activity_informatics';
    const COMPANY_ACTIVITY_MARKETING = 'company_activity_marketing';

    const COMPANY_ACTIVITY = [
        self::COMPANY_ACTIVITY_ARCHITECTURE => [
            'name' => 'Architecture',
            'enabled' => true,
        ],
        self::COMPANY_ACTIVITY_INFORMATICS => [
            'name' => 'Informatics',
            'enabled' => true,
        ],
        self::COMPANY_ACTIVITY_MARKETING => [
            'name' => 'Marketing',
            'enabled' => true,
        ],
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadCompanyActivity($manager);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function loadCompanyActivity(ObjectManager $manager)
    {
        foreach (self::COMPANY_ACTIVITY as $id => $data) {
            $companyActivity = new CompanyActivity();
            $companyActivity
                ->setName($data['name'])
                ->setEnabled($data['enabled'])
            ;
            $this->setReference($id, $companyActivity);

            $manager->persist($companyActivity);
        }
    }
}