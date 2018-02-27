<?php


use Phinx\Migration\AbstractMigration;

class AddMetricsTables extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createDownloadTable();
        $this->createUploadTable();
        $this->createLatencyTable();
        $this->createPacketLossTable();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->execute("DROP TABLE  `download`");
        $this->execute("DROP TABLE  `upload`");
        $this->execute("DROP TABLE  `latency`");
        $this->execute("DROP TABLE  `packet_loss`");
    }

    private function createDownloadTable()
    {
        $this->execute("
        CREATE TABLE IF NOT EXISTS `download` (
          `unit_id` INT(11) UNSIGNED NOT NULL,
          `timestamp` TIMESTAMP NOT NULL,
          `value` DOUBLE NOT NULL,
          PRIMARY KEY (`unit_id`, `timestamp`),
          INDEX (`unit_id`, `timestamp`)
        )
        ENGINE = InnoDB
        DEFAULT CHARSET = utf8
        ");
    }

    private function createUploadTable()
    {
        $this->execute("
        CREATE TABLE IF NOT EXISTS `upload` (
          `unit_id` INT(11) UNSIGNED NOT NULL,
          `timestamp` TIMESTAMP NOT NULL,
          `value` DOUBLE NOT NULL,
          PRIMARY KEY (`unit_id`, `timestamp`),
          INDEX (`unit_id`, `timestamp`)
        )
        ENGINE = InnoDB
        DEFAULT CHARSET = utf8
        ");
    }

    private function createLatencyTable()
    {
        $this->execute("
        CREATE TABLE IF NOT EXISTS `latency` (
          `unit_id` INT(11) UNSIGNED NOT NULL,
          `timestamp` TIMESTAMP NOT NULL,
          `value` DOUBLE NOT NULL,
          PRIMARY KEY (`unit_id`, `timestamp`),
          INDEX (`unit_id`, `timestamp`)
        )
        ENGINE = InnoDB
        DEFAULT CHARSET = utf8
        ");
    }

    private function createPacketLossTable()
    {
        $this->execute("
        CREATE TABLE IF NOT EXISTS `packet_loss` (
          `unit_id` INT(11) UNSIGNED NOT NULL,
          `timestamp` TIMESTAMP NOT NULL,
          `value` DOUBLE NOT NULL,
          PRIMARY KEY (`unit_id`, `timestamp`),
          INDEX (`unit_id`, `timestamp`)
        )
        ENGINE = InnoDB
        DEFAULT CHARSET = utf8
        ");
    }
}
