<?php
namespace Magento360\Practical\Observer;

class Save implements \Magento\Framework\Event\ObserverInterface
{

    protected $_additionalInformation;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento360\Practical\Model\AdditionalFactory  $additionalInformation
    ) {
        $this->_additionalInformation = $additionalInformation;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // Save Additional name and Additional Number in Custom table customer_additional_information
        $event = $observer->getEvent();
        $quote = $event->getQuote();
        $additional_name = $quote->getData('additional_name');
        $additional_number = $quote->getData('additional_number');
        $customer_id = $quote->getCustomer()->getId();
        $model = $this->_additionalInformation->create();
        $model->addData([
            "additional_name" => $additional_name,
            "additional_number" => $additional_number,
            "customer_id" => $customer_id
        ]);
        $saveData = $model->save();
    }
}
