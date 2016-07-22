<?php

namespace pagoflash\woocommerce\inc\hooks;

if (false === defined('ABSPATH'))
{
  header('Location: http://www.pagoflash.com');
  exit;
}

/**
 * Crea los filtros que utiliza el plugin
 *
 * @author PagoFlash International C.A. <http://www.pagoflash.com>
 * @version 1.2-20160803
 */
class FilterHook
{

  public function __construct()
  {
    add_filter('plugin_action_links_pagoflash-woocommerce/pagoflash-woocommerce.php',
      [$this, 'onFilterPluginActionLinksPagoflashWoocommerce'], 10, 4);
  }

  /**
   * @see __construct
   */
  public function onFilterPluginActionLinksPagoflashWoocommerce($p_actions, $p_plugin_file,
    $p_plugin_data, $p_context)
  {
    // no se está desactivando el plugin
    if (false === isset($p_actions['deactivate']))
    {
      return $p_actions;
    }

    // separa las partes del enlace para agregar la confirmación
    $v_link_parts = explode(' ', $p_actions['deactivate'], 2);

    // agrega un diálogo de confirmación para desactivar el plugin
    $p_actions['deactivate'] = $v_link_parts[0]
      . ' onclick="return confirm(\'' . __('This action will remove all data of this plugin, do you want to continue?',
        'kemlem') . '\')" '
      . $v_link_parts[1];

    return $p_actions;
  }

}

new FilterHook;
