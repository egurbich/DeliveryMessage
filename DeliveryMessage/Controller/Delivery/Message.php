<?php

namespace Magecom\DeliveryMessage\Controller\Delivery;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magecom\DeliveryMessage\Model\Customer;

/**
 * Class Message
 * @package Magecom\DeliveryMessage\Controller\Delivery
 */
class Message extends Action
{
    const SUCCESS_CODE = 200;
    const ERROR_CODE = 500;
    const MSG_SEPARATOR = 50000;
    const TOMORROW_DELIVERY_MSG = 'We can deliver this product tomorrow!';
    const AFTER_TOMORROW_DELIVERY_MSG = 'We can deliver this product after tomorrow!';

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * Message constructor.
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param Customer $customer
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Customer $customer
    ) {
        parent::__construct($context);
        $this->resultFactory = $resultFactory;
        $this->customer = $customer;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        try{
            if ($this->customer->zipCode() < self::MSG_SEPARATOR) {
                $result = __(self::TOMORROW_DELIVERY_MSG);
            } else {
                $result = __(self::AFTER_TOMORROW_DELIVERY_MSG);
            }

            $responseContent = [
                'success' => true,
                'message' => $result
            ];

            $resultJson->setHttpResponseCode(self::SUCCESS_CODE);
            $resultJson->setData($responseContent);

            return $resultJson;
        } catch (\Exception $e) {
            $responseContent = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            $resultJson->setHttpResponseCode(self::ERROR_CODE);
            $resultJson->setData($responseContent);
            return $resultJson;
        }
    }
}
