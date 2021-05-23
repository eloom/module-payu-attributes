<?php
/**
* 
* PayU Attributes para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo PayUAttributes
* @copyright    Copyright (c) 2021 Ã©lOOm (https://www.eloom.com.br)
* @version      1.0.0
* @license      https://www.eloom.com.br/license
*
*/
declare(strict_types=1);

namespace Eloom\PayUAttributes\Plugin\Quote;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\ShippingAddressManagement as CoreShippingAddressManagement;
use Psr\Log\LoggerInterface;

class ShippingAddressManagement {
	
	protected $logger;
	
	public function __construct(LoggerInterface $logger) {
		$this->logger = $logger;
	}
	
	public function beforeAssign(CoreShippingAddressManagement $subject,
	                             $cartId,
	                             AddressInterface $address) {
		
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