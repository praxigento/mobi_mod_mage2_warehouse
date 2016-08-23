<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Praxigento\Warehouse\Plugin\CatalogInventory\Ui\DataProvider\Product;

include_once(__DIR__ . '/../../../../../phpunit_bootstrap.php');

class AddQuantityFilterToCollection_UnitTest extends \Praxigento\Core\Test\BaseCase\Mockery
{
    /** @var  \Mockery\MockInterface */
    private $mRepoModifierProductGFrid;

    /** @var  AddQuantityFilterToCollection */
    private $obj;

    protected function setUp()
    {
        parent::setUp();
        /** create mocks */
        $this->mRepoModifierProductGFrid = $this->_mock(\Praxigento\Warehouse\Repo\Modifier\Product\Grid::class);
        /** create object to test */
        $this->obj = new AddQuantityFilterToCollection(
            $this->mRepoModifierProductGFrid
        );
    }

    public function test_aroundAddFilter()
    {
        /** === Test Data === */
        $FIELD = 'field';
        $CONDITION = 'condition';
        $EQUATION = 'some equation';
        /** === Setup Mocks === */
        $mSubject = $this->_mock(\Magento\CatalogInventory\Ui\DataProvider\Product\AddQuantityFilterToCollection::class);
        $mProceed = function () {
        };
        $mCollection = $this->_mock(\Magento\Catalog\Model\ResourceModel\Product\Collection::class);
        // $conn = $collection->getConnection();
        $mConn = $this->_mockConn();
        $mCollection
            ->shouldReceive('getConnection')->once()
            ->andReturn($mConn);
        // $select = $collection->getSelect();
        $mSelect = $this->_mockDbSelect();
        $mCollection
            ->shouldReceive('getSelect')->once()
            ->andReturn($mSelect);
        // $equation = $this->_repoModifierProductGFrid->getEquationQty();
        $this->mRepoModifierProductGFrid
            ->shouldReceive('getEquationQty')->once()
            ->andReturn($EQUATION);
        // $prepared = $conn->prepareSqlCondition($equation, $condition);
        $mPrepared = 'PREPARED CONDITION FOR HAVING';
        $mConn
            ->shouldReceive('prepareSqlCondition')->once()
            ->andReturn($mPrepared);
        // $select->having($prepared);
        $mSelect
            ->shouldReceive('having')->once();
        /** === Call and asserts  === */
        $this->obj->aroundAddFilter($mSubject, $mProceed, $mCollection, $FIELD, $CONDITION);

    }

    public function test_constructor()
    {
        /** === Call and asserts  === */
        $this->assertInstanceOf(AddQuantityFilterToCollection::class, $this->obj);
    }

}