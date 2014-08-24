<?php

class Getsquare_AdminOrderLog_Model_Resource_Entry 
    extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('admin_order_log/entry', 'log_id');
    }
}