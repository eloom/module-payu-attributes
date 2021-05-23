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

namespace Eloom\PayUAttributes\Block\Customer\Widget;

use Eloom\PayUAttributes\Api\Data\CheckoutInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\OptionInterface;
use Magento\Customer\Block\Widget\AbstractWidget;
use Magento\Customer\Helper\Address;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;

class DniType extends AbstractWidget {
	
	/**
	 * @var Session
	 */
	protected $customerSession;
	
	/**
	 * @var CustomerRepositoryInterface
	 */
	protected $customerRepository;
	
	/**
	 * Create an instance of the Dni Type widget
	 *
	 * @param Context $context
	 * @param Address $addressHelper
	 * @param CustomerMetadataInterface $customerMetadata
	 * @param CustomerRepositoryInterface $customerRepository
	 * @param Session $customerSession
	 * @param array $data
	 */
	public function __construct(Context $context,
	                            Address $addressHelper,
	                            CustomerMetadataInterface $customerMetadata,
	                            CustomerRepositoryInterface $customerRepository,
	                            Session $customerSession,
	                            array $data = []) {
		$this->customerSession = $customerSession;
		$this->customerRepository = $customerRepository;
		
		parent::__construct($context, $addressHelper, $customerMetadata, $data);
	}
	
	/**
	 * Initialize block
	 *
	 * @return void
	 */
	public function _construct() {
		parent::_construct();
		$this->setTemplate('Eloom_PayUAttributes::customer/widget/dnitype.phtml');
	}
	
	/**
	 * Check if Dni Type attribute enabled in system
	 *
	 * @return bool
	 */
	public function isEnabled() {
		return $this->_getAttribute(CheckoutInterface::DNI_TYPE) ? (bool)$this->_getAttribute(CheckoutInterface::DNI_TYPE)->isVisible() : false;
	}
	
	/**
	 * Check if Dni Type attribute marked as required
	 *
	 * @return bool
	 */
	public function isRequired() {
		return $this->_getAttribute(CheckoutInterface::DNI_TYPE) ? (bool)$this->_getAttribute(CheckoutInterface::DNI_TYPE)->isRequired() : false;
	}
	
	/**
	 * Retrieve store attribute label
	 *
	 * @param string $attributeCode
	 *
	 * @return string
	 */
	public function getStoreLabel($attributeCode) {
		$attribute = $this->_getAttribute($attributeCode);
		return $attribute ? __($attribute->getStoreLabel()) : '';
	}
	
	/**
	 * Get current customer from session
	 *
	 * @return CustomerInterface
	 */
	public function getCustomer() {
		if ($id = $this->customerSession->getCustomerId()) {
			return $this->customerRepository->getById($id);
		}
		
		return null;
	}
	
	/**
	 * Returns options from Dni Type attribute
	 *
	 * @return OptionInterface[]
	 */
	public function getDnitypeOptions() {
		return $this->_getAttribute(CheckoutInterface::DNI_TYPE)->getOptions();
	}
	
	public function getDnitype() {
		if ($this->getCustomer() != null && $this->getCustomer()->getCustomAttribute(CheckoutInterface::DNI_TYPE)) {
			return $this->getCustomer()->getCustomAttribute(CheckoutInterface::DNI_TYPE)->getValue();
		}
		
		return;
	}
}
