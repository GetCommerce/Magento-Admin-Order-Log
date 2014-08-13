<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn(
    $this->getTable('sales/order'),
    'placed_by_user',
    'varchar(40) NULL'
);
$installer->endSetup();