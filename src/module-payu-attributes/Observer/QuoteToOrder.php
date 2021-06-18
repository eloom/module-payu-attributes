<?php
/**
* 
* PayU Attributes para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo PayUAttributes
* @copyright    Copyright (c) 2021 Ã©lOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://eloom.tech/license
*
*/
declare(strict_types=1);

namespace Eloom\PayUAttributes\Observer;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class QuoteToOrder implements ObserverInterface {
	
	/**
	 * @var LoggerInterface
	 */
	protected $logger;
	
	/**
	 * @var AddressRepositoryInterface
	 */
	protected $addressRepository;
	
	public function __construct(AddressRepositoryInterface $addressRepository,
	                            LoggerInterface $logger) {
		$this->addressRepository = $addressRepository;
		$this->logger = $logger;
	}
	
	/**
	 *
	 * @param Observer $observer
	 * @return $this
	 */
	public function execute(Observer $observer) {
		$dnitype = $observer->getQuote()->getShippingAddress()->getDnitype();
		if (isset($dnitype)) {
			/**
			 * Shipping Address
			 */
			$orderShippingAdress = $observer->getOrder()->getShippingAddress();
			$orderShippingAdress->setDnitype($dnitype)->save();
			if ($addressId = $orderShippingAdress->getCustomerAddressId()) {
				$this->updateCustomerAddress($addressId, $dnitype);
			}
			
			/**
			 * Billing Address
			 */
			$orderBillingAddress = $observer->getOrder()->getBillingAddress();
			$orderBillingAddress->setDnitype($dnitype)->save();
			if ($addressId = $orderBillingAddress->getCustomerAddressId()) {
				$this->updateCustomerAddress($addressId, $dnitype);
			}
		}
		
		return $this;
	}
	
	/**
	 * Update dnitype on customer address
	 * @return void
	 * @throws LocalizedException
	 */
	protected function updateCustomerAddress($addressId, $dnitype) {
		$address = $this->addressRepository->getById($addressId);
		$address->setCustomAttribute('dnitype', $dnitype);
		
		$this->addressRepository->save($address);
	}
	
}