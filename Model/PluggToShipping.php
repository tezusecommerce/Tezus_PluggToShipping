<?php

namespace Tezus\PluggToShipping\Model;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Psr\Log\LoggerInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;

class PluggToShipping extends AbstractCarrier implements CarrierInterface {

    protected $_code = 'pluggto_shipping';
    protected $_isFixed = true;
    protected $_rateResultFactory;
    protected $_rateMethodFactory;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(RateRequest $request) {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['addressInformation']) || !isset($data['addressInformation']['custom_attributes'])) {
            return false;
        }
        $customAttrs = $data['addressInformation']['custom_attributes'];

        $shippingPrice = $this->getSpecificCustomAttr($customAttrs, 'anymarketFreight');
        $shippingCarrier = $this->getSpecificCustomAttr($customAttrs, 'anymarketCarrier');
        if ($shippingPrice == null || $shippingCarrier == null) {
            return $this;
        }

        $result = $this->_rateResultFactory->create();
        $methodCode = $data['addressInformation']['shipping_method_code'];

        $method = $this->_rateMethodFactory->create();
        $method->setCarrier($this->_code);
        $method->setCarrierTitle("AnyMarket (" . $shippingCarrier . ")");
        $method->setMethod($methodCode);
        $method->setMethodTitle($methodCode);

        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);

        $result->append($method);
        return $result;
    }

    private function getSpecificCustomAttr($customAttrs, $attrCode) {
        $valueAttr = null;
        foreach ($customAttrs as $attr) {
            if ($attr['attribute_code'] == $attrCode) {
                $valueAttr = $attr['value'];
                break;
            }
        }
        return $valueAttr;
    }

    /** @param array */
    public function getAllowedMethods() {
        return ['anymarket' => $this->getConfigData('name')];
    }
}
