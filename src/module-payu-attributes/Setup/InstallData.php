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

namespace Eloom\PayUAttributes\Setup;

use Eloom\PayUAttributes\Model\Config\Source\DniType as DniTypeSource;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface {
	
	/**
	 * @var CustomerSetupFactory
	 */
	private $customerSetupFactory;
	/**
	 * @var AttributeSetFactory
	 */
	private $attributeSetFactory;
	
	/**
	 * InstallData constructor.
	 * @param CustomerSetupFactory $customerSetupFactory
	 * @param AttributeSetFactory $attributeSetFactory
	 */
	public function __construct(CustomerSetupFactory $customerSetupFactory,
	                            AttributeSetFactory $attributeSetFactory) {
		$this->customerSetupFactory = $customerSetupFactory;
		$this->attributeSetFactory = $attributeSetFactory;
	}
	
	/**
	 * @param ModuleDataSetupInterface $setup
	 * @param ModuleContextInterface $context
	 */
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
		$setup->startSetup();
		$connection = $setup->getConnection();
		
		$customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
		
		$attrCode = 'dnitype';
		if (!$customerSetup->getAttributeId(Customer::ENTITY, $attrCode)) {
			$customerSetup->addAttribute(Customer::ENTITY, $attrCode, [
				'type' => 'varchar',
				'label' => 'DNI Type',
				'input' => 'select',
				'source' => DniTypeSource::class,
				'global' => ScopedAttributeInterface::SCOPE_STORE,
				'visible' => 1,
				'required' => true,
				'user_defined' => 1,
				'system' => 0,
				'visible_on_front' => 1,
				'group' => 'General',
				'position' => 100
			]);
			
			$customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
			$attributeSetId = $customerEntity->getDefaultAttributeSetId();
			$attributeSet = $this->attributeSetFactory->create();
			$attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
			
			$attributesToAdd = [];
			$attributesToAdd[] = $attrCode;
			
			foreach ($attributesToAdd as $code) {
				$attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, $code);
				$attribute->addData([
					'attribute_set_id' => $attributeSetId,
					'attribute_group_id' => $attributeGroupId,
					'used_in_forms' => ['adminhtml_customer', 'checkout_register', 'customer_account_create', 'customer_account_edit', 'adminhtml_checkout']
				]);
				
				$attribute->save();
			}
		}
		
		$table = $setup->getTable('quote_address');
		if ($connection->tableColumnExists($table, $attrCode) === false) {
			$connection->addColumn(
				$table,
				$attrCode,
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'length' => 5,
					'comment' => 'DNI Type'
				]
			);
		}
		
		$table = $setup->getTable('sales_order_address');
		if ($connection->tableColumnExists($table, $attrCode) === false) {
			$connection->addColumn(
				$table,
				$attrCode,
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'length' => 5,
					'comment' => 'DNI Type'
				]
			);
		}
		
		$setup->startSetup();
	}
	
}