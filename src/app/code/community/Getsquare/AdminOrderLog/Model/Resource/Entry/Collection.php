<?php
 
class Getsquare_AdminOrderLog_Model_Resource_Entry_Collection 
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('admin_order_log/entry');
    }

}