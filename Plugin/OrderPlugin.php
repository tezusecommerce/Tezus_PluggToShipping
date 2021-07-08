<?php
namespace Tezus\PluggToShipping\Plugin;
use \Magento\Sales\Model\Order;
use \Magento\Sales\Api\OrderRepositoryInterface;

class OrderPlugin {
    public function afterSave(OrderRepositoryInterface $subject, $order) {

        /** @var Order $order */
        if ($order->getShippingMethod() == NULL) {
            $order->setShippingMethod('pluggto_shipping');
            $order->save();
        }

        return $order;
    }
}
