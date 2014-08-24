<?php
/**
 * @package     Getsquare_AdminOrderName
 * @author      Getsquare magento@getsquare.co.uk
 * @copyright   2014 GetSquare
 */
class Getsquare_AdminOrderLog_Model_Observer
{

    /**
     * Adds the username to order object
     *
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function addUserName(Varien_Event_Observer $observer)
    {
        $order     = $observer->getEvent()->getOrder();
        $adminUser = Mage::getSingleton('admin/session')->getUser();
        if (! $adminUser) {
            return;
        }
        if (! $order) {
            return;
        }
        $adminLog = Mage::getModel('admin_order_log/entry');
        $adminLog->setData('placed_by_user', $adminUser->getUsername());
        $adminLog->setData('log_order_increment_id', $order->getIncrementId());
        $adminLog->save();
    }

    /**
     * Add order placed to collection
     *
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function salesOrderGridCollectionLoadBefore(Varien_Event_Observer $observer)
    {
        $collection = $observer->getOrderGridCollection();
        $collection->getSelect()
            ->joinLeft(
                array(
                    'sales_order_placed_by' => Mage::getSingleton('core/resource')->getTableName('admin_order_log/entry')
                ),
                'main_table.increment_id = sales_order_placed_by.log_order_increment_id',
                array('sales_order_placed_by.placed_by_user')
        );
    }
}