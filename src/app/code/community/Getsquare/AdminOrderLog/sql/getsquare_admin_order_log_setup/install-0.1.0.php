<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'admin_order_log/entry'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('admin_order_log/entry'))
    ->addColumn('log_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Admin Log ID')
    ->addColumn('log_order_increment_id', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
        'nullable'  => false,
        ), 'Increment Id')
    ->addColumn('placed_by_user', Varien_Db_Ddl_Table::TYPE_TEXT, 40, array(
        'nullable'  => true,
        ), 'User Name');

$installer->getConnection()->createTable($table);

$this->endSetup();