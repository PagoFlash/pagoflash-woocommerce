# Método de pago PagoFlash para WordPress/WooCommerce
-- -------------------------------------------------------------------------------------------------
-- Aspectos técnicos
-- -------------------------------------------------------------------------------------------------

Requerimientos
--------------
- PHP 5.5 o superior
- Wordpress 4.1 o superior
- WooCommerce


Instalación
------------
1. Descargar el contenido comprimido (.zip).
2. Iniciar sesión en al área administrativa de Wordpress para tu sitio web
3. Click en "Subir nuevo plugin" y seleccionar el plugin descargado (.zip)
4. Dirígete desde tu gestor de archivos hasta wp-content/plugins/ y renombra la carpeta "pagoflash-woocommerce-master" a "pagoflash-woocommerce".
4. Ir al área de administración de plugins y activar el plugin
  "PagoFlash - Método de Pago para WooCommerce"



-- -------------------------------------------------------------------------------------------------
-- Uso
-- -------------------------------------------------------------------------------------------------
01. Entra a la sección de ajustes de WooCommerce y configura el plugin de PagoFlash. Esto lo puedes
  hacer a través de la URL "{mi-sitio-web}/wp-admin/admin.php?page=wc-settings&tab=checkout&section"

02. Crea una nueva página con el siguiente URL "{mi-sitio-web}/pagoflash-callback"

03. Eso es todo, ahora tus clientes podrán realizarte los pagos utilizando PagoFlash

-- -------------------------------------------------------------------------------------------------
-- Ambiente de prueba
-- -------------------------------------------------------------------------------------------------
Para hacer pruebas ingresa en nuestro sitio de pruebas y [regístra una cuenta de negocios](http://app-test2.pagoflash.com/profile/register/business), luego de llenar y confirmar tus datos, completa los datos de tu perfil, registra un punto de venta, llena los datos necesarios y una vez registrado el punto, la plataforma generará códigos **key_token** y **key_secret** que encontrarás en la pestaña **Integración** del punto de venta, utilíza los parámetros para configurar tu plugin en woocommerce, no olvides habilitar el "Test Mode" o "Módo de Prueba" de Woocommerce para hacer las pruebas.

-- -------------------------------------------------------------------------------------------------
-- Configuración
-- -------------------------------------------------------------------------------------------------
El área de configuración del plugin se encuentra dentro de la sección de ajustes de WooCommerce, en
el apartado de "Finalizar Compra" y posee las siguientes opciones configurables:

  - Activo: Activa o desactiva el uso de PagoFlash como pasarela de pago.

  - Título: Requerido. Título de la opción de pago que se mostrará cuando el usuario valla a
    completar su compra.

  - Descripción: Requerido. Descripción o instrucciones que se mostrarán al usuario cuando valla a
    seleccionar el pago.

  - Mensaje al terminar exitosamente: Requerido. Mensaje que se mostrará al usuario cuando la compra
    haya sido completada exitosamente.

  - Mensaje en caso de error: Requerido. Mensaje que se mostrará al usuario cuando no haya sido
    posible completar su pago de forma exitosa.

  - Key Token: Requerido. Ficha única que genera PagoFlash al momento de registrar un punto de venta
    virtual.

  - Key Secret: Requerido. Ficha única complementaria que genera PagoFlash al momento de registrar
    un punto de venta virtual.

  - URL Callback: Solo lectura. El contenido de este campo debe ser copiado y pegado en el campo
    "URL callback" del formulario de registro del punto de venta virtual en PagoFlash.

  - Modo de prueba: Activa o desactiva el modo de prueba del plugin. Cuando se está en modo de
    prueba las transacciones no implican un movimiento real de dinero.

  - Log detallado: Activa o desactiva la escritura detallada del funcionamiento del plugin en el
    registro de WooCommerce (Estado del sistema -> Registro). Si esta opción está desactivada solo
    se escribirán los mensajes de error.

  - Email para notificar errores: Requerido. Dirección de email hacia la cual se enviarán los
    detalles técnicos de los errores que ocurran mientras los usuarios utilizan PagoFlash como
    pasarela de pago. Generalmente esta dirección de email será la del personal técnico responsable
    del funcionamiento del sitio web.

  - Notificar errores a PagoFlash: Permítenos saber que ocurrió un error con nuestro plugin y así
    podremos ayudarte proactivamente a solucionarlo.

    Esta opción envía una copia de los detalles técnicos de los errores hacia nuestro equipo de
    soporte para determinar que está sucediendo y darte soluciones.

    El mensaje no contiene información sensible, solo nos avisa que algo no va bien y nos entrega
    los datos, que ya están en nuestra plataforma, para atender la eventualidad puntualmente.

-- -------------------------------------------------------------------------------------------------
-- Agregar moneda (bs)
-- -------------------------------------------------------------------------------------------------

Para configurar woocommerce para que acepte bolívares como moneda, agrega la siguiente función al final del archivo functions.php de tu theme.

```php
add_filter( 'woocommerce_currencies', 'add_my_currency' );

function add_my_currency( $currencies ) {
     $currencies['ABC'] = __( 'Bolívares', 'woocommerce' );
     return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
  
function add_my_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'ABC': $currency_symbol = 'Bs. '; break;
     }
     return $currency_symbol;
}
```

-- -------------------------------------------------------------------------------------------------
-- Personalización
-- -------------------------------------------------------------------------------------------------

Plantillas
----------
Para personalizar la organización visual de los elementos mostrados por el plugin, pueden editarse
los archivos que se encuentran dentro del directorio "templates".
