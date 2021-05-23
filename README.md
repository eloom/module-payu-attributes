# PayU Attributes para Magento 2

Crea el atributo "DNI Type" - Tipo de documento pagador - en Magento para cumplir con la legislación da Argentina y Colombia.

### DNI Type para Argentina

|   Code    |   Description |
|   :---:   |   :---:       |
|	CUIL	|	Para pagadores argentinos   |
|	CUIT	|	Pasaporte para pagadores extranjeros    |

### DNI Type para Colombia

|   Code    |   Description |
|   :---:   |   :---:       |
|	CC		|	Cédula de ciudadanía    |
|	CE 		|	Cédula de extranjería   |
|	NIT		|	En caso de ser una empresa  |
|	TI		|	Tarjeta de Identidad    |
|	PP 		|	Pasaporte   |
|	IDC     |	Identificador único de cliente, para el caso de ID’s únicos de clientes/usuarios de servicios públicos	|
|	CEL 	|	En caso de identificarse a través de la línea del móvil	|
|	RC 		|	Registro civil de nacimiento	|
|	DE 		|	Documento de identificación extranjero 	|

## Licencia


## Inserte el bloque "DNI Type" en el Formulario de registro de cliente

En el archivo "Store Theme/Magento_Customer/templates/form/register.phtml", antes del campo Taxvat, inserte el fragmento de código

```
<?php $_dni = $block->getLayout()->createBlock(\Eloom\PayUAttributes\Block\Customer\Widget\DniType::class) ?>
<?php if ($_dni->isEnabled()): ?>
    <?= $_dni->setDnitype($formData->getDnitype())->toHtml() ?>
<?php endif ?>
```

## Inserte el bloque "DNI Type" en el Formulario de edición del cliente

En el archivo "Store Theme/Magento_Customer/templates/form/edit.phtml", antes del campo Taxvat, inserte el fragmento de código

```
<?php $_dni = $block->getLayout()->createBlock(\Eloom\PayUAttributes\Block\Customer\Widget\DniType::class) ?>
<?php if ($_dni->isEnabled()): ?>
    <?= $_dni->setDnitype($block->getDnitype())->toHtml() ?>
<?php endif ?>
```

## Enlaces

* [Web site](https://www.eloom.com.br/payu)
* [Documentación](https://docs.eloom.com.br/es/payu)
* [Issue tracker](https://github.com/eloom/module-payu-attributes/issues)
* [Composer packages](https://packagist.org/packages/eloom/module-payu-attributes)
* [Codigo fuente](https://github.com/eloom/module-payu-attributes)