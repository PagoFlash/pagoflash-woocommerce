<?php

namespace pagoflash\woocommerce\inc;

if (false === defined('ABSPATH'))
{
  header('Location: http://www.pagoflash.com');
  exit;
}

/**
 * Gestor de plantillas
 *
 * @author PagoFlash International C.A. <http://www.pagoflash.com>
 * @version 1.2-20160803
 */
class TemplateManager
{

  /**
   * Carga los datos de una plantilla y le aplica las variables asignadas
   * 
   * @param string $p_template Nombre de la plantilla
   * @param array $p_vars Variables que se utilizarán en la plantilla
   * @param boolean $p_buffer_output Indica si la salida debe ser devuelta por
   * la función
   */
  public function loadTemplate($p_template, $p_vars = [],
    $p_buffer_output = false)
  {
    // genera el nombre completo de la plantilla
    $p_template = dirname(__FILE__) . "/../templates/{$p_template}.php";

    // la salida debe ser devuelta por la función
    if ($p_buffer_output)
    {
      ob_start();
    }

    // extrae las variabels que se utilizarán
    extract($p_vars);

    // agrega la plantilla
    require $p_template;

    // la salida debe ser devuelta por la función
    if ($p_buffer_output)
    {
      return ob_get_clean();
    }
  }

}
