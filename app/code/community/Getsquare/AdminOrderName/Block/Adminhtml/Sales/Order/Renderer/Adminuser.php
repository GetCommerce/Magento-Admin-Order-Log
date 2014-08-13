<?php
/**
 * @package     Getsquare_AdminOrderName
 * @author      Getsquare magento@getsquare.co.uk
 * @copyright   2014 GetSquare
 */
class Getsquare_AdminOrderName_Block_Adminhtml_Sales_Order_Renderer_Adminuser extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Renders grid column
     *
     * @param Varien_Object $row
     * @return mixed
     */
    public function _getValue(Varien_Object $row)
    {
        if(!$row) {
            return;
        }
        $order = Mage::getModel('sales/order')->loadByIncrementId($row->getIncrementId());
        if($order) {
            $data = $order->getPlacedByUser();
        } else {
            $data = $this->getColumn()->getDefault();
        }
        return $this->escapeHtml($data);
    }
}
