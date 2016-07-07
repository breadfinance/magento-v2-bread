<?php
/**
 * Payment Info Block
 *
 * @author  Bread   copyright   2016
 * @author  Joel    @Mediotype
 * @author  Miranda @Mediotype
 */
namespace Bread\BreadCheckout\Block\Payment;

class Info extends \Magento\Payment\Block\Info
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $dataObjectFactory;

    public function __construct(
        \Magento\Framework\DataObjectFactory $dataObjectFactory
    ) {
        $this->dataObjectFactory = $dataObjectFactory;
    }
    /**
     * Display Information For Admin View
     *
     * @param null $transport
     * @return null|\Magento\Framework\DataObject
     */
    protected function _prepareSpecificInformation($transport = null)
    {
        if (null !== $this->_paymentSpecificInformation) {
            return $this->_paymentSpecificInformation;
        }

        $info = $this->getInfo();
        $transport = $this->dataObjectFactory->create();
        $transport = parent::_prepareSpecificInformation($transport);

        $transport->addData( [__('Financing Tx Id') => $info->getTransactionId()] );
        return $transport;
    }

}
