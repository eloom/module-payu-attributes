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

namespace Eloom\PayUAttributes\Plugin\Checkout;

use Eloom\PayUAttributes\Api\Data\CheckoutInterface;
use Eloom\PayUAttributes\Model\Config\Source\DniType;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class LayoutProcessor implements LayoutProcessorInterface {
	
	private $dniType;
	
	public function __construct(DniType $dniType) {
		$this->dniType = $dniType;
	}
	
	public function process($jsLayout) {
		$dniField = [
			'component' => 'Eloom_PayUAttributes/js/form/element/dnitype',
			'config' => [
				'customScope' => 'shippingAddress.custom_attributes',
				'customEntry' => null,
				'template' => 'ui/form/field',
				'elementTmpl' => 'ui/form/element/select',
				'tooltip' => [
					'description' => 'Tipo de documento del pagador',
				],
			],
			'dataScope' => 'shippingAddress.custom_attributes' . '.' . CheckoutInterface::DNI_TYPE,
			'label' => 'DNI Type',
			'provider' => 'checkoutProvider',
			'sortOrder' => 15,
			'validation' => [
				'required-entry' => true
			],
			'options' => $this->getFieldOptions(),
			'filterBy' => null,
			'customEntry' => null,
			'visible' => true,
			'value' => ''
		];
		
		$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][CheckoutInterface::DNI_TYPE] = $dniField;
		
		return $jsLayout;
	}
	
	/**
	 * Retrieve field options from attribute configuration
	 *
	 * @return array
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	protected function getFieldOptions() {
		return $this->dniType->getAllOptions();
	}
}