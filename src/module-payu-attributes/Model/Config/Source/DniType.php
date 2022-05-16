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

namespace Eloom\PayUAttributes\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class DniType extends AbstractSource {
	
	private $allowedCurrencies = ['ARS', 'COP'];
	
	private $scopeConfig;
	
	/**
	 *
	 * @param ScopeConfigInterface $scopeConfig
	 */
	public function __construct(ScopeConfigInterface $scopeConfig) {
		$this->scopeConfig = $scopeConfig;
	}
	
	/**
	 * Get all options
	 *
	 * @return array
	 */
	public function getAllOptions() {
		$currency = $this->scopeConfig->getValue('currency/options/default', ScopeInterface::SCOPE_STORE, null);
		
		if (!in_array($currency, $this->allowedCurrencies)) {
			throw new \Exception(sprintf(__("%s is not an allowed currency."), $currency));
		}
		
		$ars = [
			'CUIL' => __('Para pagadores argentinos'),
			'CUIT' => __('Pasaporte para pagadores extranjeros')
		];
		
		$cop = [
			'CC' => __('Cédula de ciudadanía'),
			'CE' => __('Cédula de extranjería'),
			'NIT' => __('En caso de ser una empresa'),
			'TI' => __('Tarjeta de Identidad'),
			'PP' => __('Pasaporte'),
			'IDC' => __('Identificador único de cliente, para el caso de ID’s únicos de clientes/usuarios de servicios públicos'),
			'CEL' => __('En caso de identificarse a través de la línea del móvil'),
			'RC' => __('Registro civil de nacimiento'),
			'DE' => __('Documento de identificación extranjero')
		];
		
		if ($this->_options === null) {
			$entries = [
				'ARS' => $ars,
				'COP' => $cop
			];
			
			if (isset($entries[$currency])) {
				foreach ($entries[$currency] as $key => $value) {
					$this->_options[] = ['value' => $key, 'label' => $value];
				}
			}
		}
		
		return $this->_options;
	}
}