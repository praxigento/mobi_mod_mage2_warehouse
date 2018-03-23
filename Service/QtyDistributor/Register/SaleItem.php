<?php
/**
 *
 */

namespace Praxigento\Warehouse\Service\QtyDistributor\Register;

use Praxigento\Warehouse\Repo\Query\Lots\By\Product\Id\Get as AGet;
use Praxigento\Warehouse\Service\QtyDistributor\Register\SaleItem\Request as ARequest;
use Praxigento\Warehouse\Service\QtyDistributor\Register\SaleItem\Response as AResponse;

/**
 *
 */
class SaleItem
{
    /** @var \Praxigento\Warehouse\Repo\Query\Lots\By\Product\Id\Get */
    protected $daoGetLots;
    /** @var \Praxigento\Warehouse\Service\QtyDistributor\Register\A\Sale\Item\Qty */
    private $subQtyReg;

    public function __construct(
        \Praxigento\Warehouse\Repo\Query\Lots\By\Product\Id\Get $daoGetLots,
        \Praxigento\Warehouse\Service\QtyDistributor\Register\A\Sale\Item\Qty $subQtyReg
    )
    {
        $this->daoGetLots = $daoGetLots;
        $this->subQtyReg = $subQtyReg;
    }

    /**
     * @param ARequest $request
     * @return AResponse
     */
    public function exec(ARequest $request)
    {
        $result = new AResponse();
        $itemId = $request->getItemId();
        $prodId = $request->getProductId();
        $stockId = $request->getStockId();
        $qty = $request->getQuantity();
        if ($qty > 0) {
            /* get list of lots for the product */
            $query = $this->daoGetLots->build();
            $conn = $query->getConnection();
            $bind = [
                AGet::BND_PROD_ID => $prodId,
                AGet::BND_STOCK_ID => $stockId
            ];
            $lots = $conn->fetchAll($query, $bind);
            $this->subQtyReg->exec($itemId, $qty, $lots);
        }
        $result->markSucceed();
        return $result;
    }
}