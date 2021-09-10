<?php
/**
* 
* PayU Attributes para Magento 2
* 
* @category     elOOm
* @package      Modulo PayUAttributes
* @copyright    Copyright (c) 2021 Ã©lOOm (https://eloom.tech)
* @version      1.0.1
* @license      https://eloom.tech/license
*
*/
declare(strict_types=1);

namespace Eloom\PayUAttributes\Plugin\Quote;

use Eloom\PayUAttributes\Api\Data\CheckoutInterface;
use Magento\Quote\Model\CustomerManagement as CoreCustomerManagement;
use Magento\Quote\Model\Quote as QuoteEntity;
use Psr\Log\LoggerInterface;

class CustomerManagement {
	
	protected $logger;
	
	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}
	
	public function beforePopulateCustomerInfo(CoreCustomerManagement $subject,
	                                           QuoteEntity $quote) {
		
		$customer = $quote->getCustomer();
		if ($customer &&
			$customer->getId() &&
			$customer->getCustomAttribute(CheckoutInterface::DNI_TYPE)) {
			
			$dniType = $customer->getCustomAttribute(CheckoutInterface::DNI_TYPE)->getValue();
			
			$quote->getShippingAddress()->setDnitype($dniType);
			$quote->getBillingAddress()->setDnitype($dniType);
		}
	}
}