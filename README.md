# PayU Attributes para Magento 2

Crea el atributo "DNI Type" - Tipo de documento pagador - en Magento para cumplir con la legislación da Argentina y Colombia.

## Requerimientos Técnicos

| Requerimientos | Versión                |
| ------ |------------------------|
| Magento Open Source, Adobe Commerce | ~2.3.2, ~2.4           |
| PHP, PHP-FPM | ~7.2, ~7.3, ~7.4, ~8.1 |

## Características y Funcionalidades

- [x] inserte el campo **dniType** para tiendas na **Argentina** y **Colombia**, en las páginas:
    
    - [x] crear / editar cuenta de cliente;

    - [x] do checkout, en modo anónimo.    

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

## Instalando o módulo

Antes de comenzar, asegúrese de haber instalado Composer. En su terminal, acceda a la carpeta raíz de Magento 2 y ejecute los siguientes comandos:

1. Agregue estas líneas a su archivo composer.json o agregue una nueva URL de repositorio si ya tiene una o más:

```
"repositories": [
    {
        "type": "composer", 
        "url": "https://eloom.repo.repman.io"
    }
]
```

```
composer clearcache
```

Versión ~2.4.4 - Adobe Commerce / Magento Open Source
```
composer require eloom/module-payu-attributes:2.0.0
```

Versión ~2.3.2 e ~2.4.3 - Adobe Commerce / Magento Open Source
```
composer require eloom/module-payu-attributes:1.0.1
```

```
bin/magento setup:upgrade
```

```
bin/magento setup:di:compile
```

```
bin/magento setup:static-content:deploy
```

```
bin/magento c:c && bin/magento c:f
```

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

* [Web site](https://eloom.tech/payu-latam)
* [Documentación](https://docs.eloom.tech/es/payu-latam)
* [Issue tracker](https://github.com/eloom/module-payu-attributes/issues)
* [Packagist](https://packagist.org/packages/eloom/module-payu-attributes)
* [Repmain](https://app.repman.io/organization/eloom/package/e984fde3-d48a-480b-8b23-b0d04ca78e1b/details)
* [Codigo fuente](https://github.com/eloom/module-payu-attributes)