<?php

namespace pagoflash\woocommerce\inc\hooks;

if (false === defined('ABSPATH'))
{
  header('Location: http://www.enebruskemlem.com.ve');
  exit;
}

/**
 * Crea las acciones que utiliza el plugin
 *
 * @author Enebrus Kem Lem, C.A. <contacto@enebruskemlem.com.ve>
 */
class ActionHook
{

  public function __construct()
  {
    add_action('parse_request', [$this, 'onActionParseRequest'], 0, 0);
  }

  /**
   * Evalúa la URL solicitada para tomar las acciones que sean necesarias
   */
  public function onActionParseRequest()
  {
    global $wp;
    /* @var $wp \WP */

    global $woocommerce;
    /* @var $woocommerce \WooCommerce */

    // no está definido el parámetro que identifica el punto de entrada
    if (false === isset($wp->query_vars['pagename']))
    {
      return;
    }
    
    // no es la URL para atender la respuesta de PagoFlash
    if ($wp->query_vars['pagename'] !== 'pagoflash-callback')
    {
      return;
    }

    // no se tiene el parámetro de control de PagoFlash
    if (false === isset($_GET['tk']) or false === isset($_GET['callback']))
    {
      header('Location: ' . site_url());
      exit;
    }

    global $pagoflash_woocommerce;
    /* @var $pagoflash_woocommerce \pagoflash\woocommerce\inc\Plugin */

    // obtiene la instancia de la pasarela de pago PagoFlash para poder utilizar su configuración
    $v_gateway = $pagoflash_woocommerce->retrievePagoflashGateway();
    /* @var $v_gateway \WC_Gateway_Pagoflash */

    // instancia la clase que permite hacer uso del API de PagoFlash
    $v_pagoflash_api = $pagoflash_woocommerce->retrievePagoFlashAPI(
      $v_gateway->get_option('keyToken'), //
      $v_gateway->get_option('keySecret'), //
      $v_gateway->retrieveCallbackUrl(), //
      $v_gateway->isTestMode());
    /* @var $v_pagoflash_api \apiPagoflash */

    // prueba que el token recibido sea válido
    $v_raw_response = $v_pagoflash_api->validarTokenDeTransaccion($_GET['tk'],
      $_SERVER['HTTP_USER_AGENT']);
    $v_response = json_decode($v_raw_response);

    //Valida data por curl
    if($_GET['callback'] == 1){
      // la respuesta no fue satisfactoria
      if ((null === $v_response) || ($v_response->cod != 1))
      {
        // agrega el mensaje en el log de errores
        $v_gateway->log("response: {$v_raw_response}");
        exit;
      }
    }

    // obtiene los datos de la orden de compra
    $v_order = new \WC_Order($v_response->order_number);
    /* @var $v_order \WC_Order */

    //Muestra mensaje con status de la operación 
    if($_GET['callback'] == 0){
      if($v_order->post_status == 'wc-completed'){
          $pagoflash_woocommerce->template_manager->loadTemplate('gateway/callback/success',
            [
            'response' => $v_response,
            'message' => $v_gateway->get_option('successMessage')
          ]);
          exit;
      }else{
        $pagoflash_woocommerce->template_manager->loadTemplate('gateway/callback/error',
        [
        'response' => $v_response,
        'message' => $v_gateway->get_option('errorMessage')
      ]);
        exit;

      }
    }

    // actualiza el estatus de la orden
    $v_order->payment_complete($_GET['tk']);

    // limpia el carro de compra
    $woocommerce->cart->empty_cart();


    exit;
  }

}

new ActionHook;