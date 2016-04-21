<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Praxigento\Warehouse\Controller\Adminhtml\Warehouses;

use Magento\Backend\App\Action;
use Praxigento\Warehouse\Config as Cfg;
use Praxigento\Warehouse\Controller\Adminhtml\Base;

class Index extends Base
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(Cfg::MODULE . '::' . Cfg::ACL_CATALOG_WAREHOUSES);
        $this->_addBreadcrumb(__('Warehouses'), __('Warehouses'));
        $resultPage->getConfig()->getTitle()->prepend(__('Warehouses'));
        return $resultPage;
    }
}