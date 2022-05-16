<?php
/**
* 
* PayU Attributes para Magento 2
* 
* @category     elOOm
* @package      Modulo PayUAttributes
* @copyright    Copyright (c) 2022 elOOm (https://eloom.tech)
* @version      2.0.0
* @license      https://eloom.tech/license
*
*/
declare(strict_types=1);

namespace Eloom\PayUAttributes\Plugin\Quote;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\BillingAddressManagement as CoreBillingAddressManagement;
use Psr\Log\LoggerInterface;

class BillingAddressManagement {
	
	protected $logger;
	
	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}
	
	public function beforeAssign(CoreBillingAddressManagement $subject,
	                             $cartId,
	                             AddressInterface $address,
	                             $useForShipping = false) {
		
		$extensionAttributes = $address->getExtensionAttributes();
		$dniType = $extensionAttributes->getDnitype();
		
		if (!empty($dniType)) {
			try {
				$address->setDnitype($dniType);
			} catch (\Exception $e) {
				$this->logger->critical($e->getMessage());
			}
		}
	}
}