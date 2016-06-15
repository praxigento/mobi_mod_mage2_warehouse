<?php
/**
 * Replace default stock ID by stock ID correlated to store (group) 
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Warehouse\Plugin\CatalogInventory\Model\ResourceModel\Stock;


class Status
{
    /** @var  \Praxigento\Warehouse\Tool\IStockManager */
    protected $_manStock;

    public function __construct(
        \Praxigento\Warehouse\Tool\IStockManager $manStock
    ) {
        $this->_manStock = $manStock;
    }

    public function afterAddStockDataToCollection(
        \Magento\CatalogInventory\Model\ResourceModel\Stock\Status $subject,
        $result
    ) {
        /** @var \Magento\Framework\Db\Select $select */
        $select = $result->getSelect();
        $from = $select->getPart('from');
        $join = $from['stock_status_index'];
        $cond = $join['joinCondition'];
        $stockId = $this->_manStock->getCurrentStockId();
        $fixed = str_replace('.stock_id = 1', '.stock_id = ' . $stockId, $cond);
        $join['joinCondition'] = $fixed;
        $from['stock_status_index'] = $join;
        $select->setPart('from', $from);
        return $result;
    }
}