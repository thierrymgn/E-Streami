<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $languages = [
            ['label' => 'Français', 'code' => 'FR'],
            ['label' => 'Anglais', 'code' => 'EN'],
            ['label' => 'Espagnol', 'code' => 'ES'],
            ['label' => 'Allemand', 'code' => 'DE'],
            ['label' => 'Italien', 'code' => 'IT'],
            ['label' => 'Portugais', 'code' => 'PT'],
            ['label' => 'Néerlandais', 'code' => 'NL'],
            ['label' => 'Russe', 'code' => 'RU'],
            ['label' => 'Chinois', 'code' => 'ZH'],
            ['label' => 'Japonais', 'code' => 'JA'],
            ['label' => 'Coréen', 'code' => 'KO'],
            ['label' => 'Arabe', 'code' => 'AR'],
            ['label' => 'Hindi', 'code' => 'HI'],
            ['label' => 'Turc', 'code' => 'TR'],
            ['label' => 'Vietnamien', 'code' => 'VI'],
            ['label' => 'Thaï', 'code' => 'TH'],
            ['label' => 'Suédois', 'code' => 'SV'],
            ['label' => 'Danois', 'code' => 'DA'],
            ['label' => 'Finnois', 'code' => 'FI'],
            ['label' => 'Norvégien', 'code' => 'NO'],
            ['label' => 'Polonais', 'code' => 'PL'],
            ['label' => 'Tchèque', 'code' => 'CS'],
            ['label' => 'Slovaque', 'code' => 'SK'],
            ['label' => 'Hongrois', 'code' => 'HU'],
            ['label' => 'Grec', 'code' => 'EL'],
            ['label' => 'Bulgare', 'code' => 'BG'],
            ['label' => 'Roumain', 'code' => 'RO'],
            ['label' => 'Catalan', 'code' => 'CA'],
            ['label' => 'Basque', 'code' => 'EU'],
            ['label' => 'Galicien', 'code' => 'GL'],
        ];

        foreach ($languages as $language) {
            $languageEntity = new Language();
            $languageEntity->setCode($language['label']);
            $languageEntity->setName($language['code']);
            $manager->persist($languageEntity);
        }

        $manager->flush();
    }
}
