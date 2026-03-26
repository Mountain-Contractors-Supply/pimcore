<?php

declare(strict_types=1);

namespace App\Migration;

use App\Consts\Consts;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260326141735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates a classification store';
    }

    public function up(Schema $schema): void
    {
        $classificationStore = \Pimcore\Model\DataObject\Classificationstore\StoreConfig::getByName(Consts::ATTRIBUTE_STORE);

        if ($classificationStore) {
            return;
        }

        $classificationStore = new \Pimcore\Model\DataObject\Classificationstore\StoreConfig();
        $classificationStore->setName(Consts::ATTRIBUTE_STORE);
        $classificationStore->save();
    }

    public function down(Schema $schema): void
    {
        $classificationStore = \Pimcore\Model\DataObject\Classificationstore\StoreConfig::getByName(Consts::ATTRIBUTE_STORE);

        if ($classificationStore) {
            $classificationStore->delete();
        }
    }
}
