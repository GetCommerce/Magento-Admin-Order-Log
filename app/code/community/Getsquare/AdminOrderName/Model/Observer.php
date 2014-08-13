<?php

/**
 * @package     Getsquare_AdminOrderName
 * @author      Getsquare magento@getsquare.co.uk
 * @copyright   2014 GetSquare
 */
class Getsquare_AdminOrderName_Model_Observer
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
        $order->setData('placed_by_user', $adminUser->getUsername());
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
            ->join(
                array(
                    'sales_order_placed_by' => Mage::getSingleton('core/resource')->getTableName('sales/order')
                ),
                'main_table.entity_id = sales_order_placed_by.entity_id',
                array('sales_order_placed_by.placed_by_user')
            );

    }

    /**
     * Add column to grid
     *
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function beforeBlockToHtml(Varien_Event_Observer $observer)
    {
        $grid = $observer->getBlock();

        /**
         * Mage_Adminhtml_Block_Customer_Grid
         */
        if ($grid instanceof Mage_Adminhtml_Block_Customer_Grid) {
            $grid->addColumnAfter(
                'created_at',
                array(
                    'header' => Mage::helper('getsquare_adminordername')->__('Order Placed By'),
                    'index'  => 'placed_by_user'
                ),
                'placed_by_user'
            );
        }
    }

    /**
     * Adds attribute to grid collection
     *
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function beforeCollectionLoad(Varien_Event_Observer $observer)
    {
        $collection = $observer->getCollection();
        if (! isset($collection)) {
            return;
        }
        if ($collection instanceof Mage_Customer_Model_Resource_Customer_Collection) {
            /* @var $collection Mage_Customer_Model_Resource_Customer_Collection */
            $collection->addAttributeToSelect('placed_by_user');
        }
    }
}