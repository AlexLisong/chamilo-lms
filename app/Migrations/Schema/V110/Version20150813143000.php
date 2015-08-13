<?php
/* For licensing terms, see /license.txt */

namespace Application\Migrations\Schema\V110;

use Application\Migrations\AbstractMigrationChamilo;
use Doctrine\DBAL\Schema\Schema;

/**
 * Calendar color
 */
class Version20150813143000 extends AbstractMigrationChamilo
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSettingCurrent(
            'prevent_multiple_simultaneous_login',
            null,
            'radio',
            'Security',
            'false',
            'PreventMultipleSimultaneousLoginTitle',
            'PreventMultipleSimultaneousLoginComment',
            null,
            null,
            1,
            true,
            false,
            [
                0 => ['value' => 'true', 'text' => 'Yes'],
                1 => ['value' => 'false', 'text' => 'No']
            ]
        );
        $this->addSettingCurrent(
            'gradebook_detailed_admin_view',
            null,
            'radio',
            'Gradebook',
            'false',
            'ShowAdditionalColumnsInStudentResultsPageTitle',
            'ShowAdditionalColumnsInStudentResultsPageComment',
            null,
            null,
            1,
            true,
            false,
            [
                0 => ['value' => 'true', 'text' => 'Yes'],
                1 => ['value' => 'false', 'text' => 'No']
            ]
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $entityManage = $this->getEntityManager();

        $deleteOptions = $entityManage->createQueryBuilder();
        $deleteSettings = $entityManage->createQueryBuilder();

        $deleteOptions->delete('ChamiloCoreBundle:SettingsOptions', 'o')
            ->andWhere(
                $deleteOptions->expr()->in(
                    'o.variable',
                    [
                        'prevent_multiple_simultaneous_login',
                        'gradebook_detailed_admin_view'
                    ]
                )
            );
        $deleteOptions->getQuery()->execute();

        $deleteSettings->delete('ChamiloCoreBundle:SettingsCurrent', 's')
            ->andWhere(
                $deleteSettings->expr()->in(
                    's.variable',
                    [
                        'prevent_multiple_simultaneous_login',
                        'gradebook_detailed_admin_view'
                    ]
                )
            );
        $deleteSettings->getQuery()->execute();
    }
}
