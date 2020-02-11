<?php

declare(strict_types=1);

namespace Magecom\DeliveryMessage\Controller\Delivery;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magecom\DeliveryMessage\Model\Customer;
use Psr\Log\LoggerInterface;

/**
 * Class Message
 */
class Message extends Action
{
    /**
     * Success code
     */
    private const SUCCESS_CODE = 200;

    /**
     * Error code
     */
    private const ERROR_CODE = 500;

    /**
     * Message separator (for example only, can be replaced with array of Zip Codes and Messages relation)
     */
    private const MSG_SEPARATOR = 50000;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Message constructor.
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param Customer $customer
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Customer $customer,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultFactory = $resultFactory;
        $this->customer = $customer;
        $this->logger = $logger;
    }

    /**
     * Getting message for customer according to received Zip Code
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        try{

            $result = ($this->customer->zipCode() < self::MSG_SEPARATOR) ? __('Deliver tomorrow!') : __('Deliver after tomorrow!');

            $responseContent = [
                'success' => true,
                'message' => $result
            ];

            $resultCode = self::SUCCESS_CODE;

        } catch (\Exception $e) {

            $responseContent = [
                'success' => false,
                'message' => 'Something went wrong during getting delivery message'
            ];

            $resultCode = self::ERROR_CODE;

            $this->logger->error('Error during showing delivery message on PDP: ' . $e->getMessage());

        }

        $resultJson->setHttpResponseCode($resultCode);
        $resultJson->setData($responseContent);
        return $resultJson;
    }
}
