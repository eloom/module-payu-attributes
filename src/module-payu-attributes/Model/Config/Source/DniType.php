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

namespace Eloom\PayUAttributes\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class DniType extends AbstractSource {
	
	/**
	 * Get all options
	 *
	 * @return array
	 */
	public function getAllOptions() {
		if ($this->_options === null) {
			$entries = [
				'CUIL' => __('Para pagadores argentinos'),
				'CUIT' => __('Pasaporte para pagadores extranjeros'),
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
			
			foreach ($entries as $key => $value) {
				$this->_options[] = ['value' => $key, 'label' => $value];
			}
		}
		
		return $this->_options;
	}
}