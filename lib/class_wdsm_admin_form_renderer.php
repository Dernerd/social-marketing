<?php
/**
 * Renders form elements for admin settings pages.
 */
class Wdsm_AdminFormRenderer {
	private $_help;
	
	function __construct () {
		if (!class_exists('Psource_HelpTooltips')) require_once WDSM_PLUGIN_BASE_DIR . '/lib/external/class_wd_help_tooltips.php';
		$this->_help = new Psource_HelpTooltips();
		$this->_help->set_icon_url(WDSM_PLUGIN_URL . '/img/information.png');
	}

	function _get_option ($key=false, $pfx='wdsm') {
		$opts = get_option($pfx);
		if (!$key) return $opts;
		return wdsm_getval($opts, $key);
	}

	function _create_checkbox ($name) {
		$opt = $this->_get_option();
		$value = wdsm_getval($opt, $name);
		return
			"<input type='radio' name='wdsm[{$name}]' id='{$name}-yes' value='1' " . ((int)$value ? 'checked="checked" ' : '') . " /> " .
				"<label for='{$name}-yes'>" . __('Ja', 'wdsm') . "</label>" .
			'&nbsp;' .
			"<input type='radio' name='wdsm[{$name}]' id='{$name}-no' value='0' " . (!(int)$value ? 'checked="checked" ' : '') . " /> " .
				"<label for='{$name}-no'>" . __('Nein', 'wdsm') . "</label>" .
		"";
	}

	function _create_sub_checkbox ($key, $name) {
		$opt = $this->_get_option($key);
		$value = wdsm_getval($opt, $name);
		return
			"<input type='radio' name='wdsm[{$key}][{$name}]' id='{$key}-{$name}-yes' value='1' " . ((int)$value ? 'checked="checked" ' : '') . " /> " .
				"<label for='{$key}-{$name}-yes'>" . __('Ja', 'wdsm') . "</label>" .
			'&nbsp;' .
			"<input type='radio' name='wdsm[{$key}][{$name}]' id='{$key}-{$name}-no' value='0' " . (!(int)$value ? 'checked="checked" ' : '') . " /> " .
				"<label for='{$key}-{$name}-no'>" . __('Nein', 'wdsm') . "</label>" .
		"";
	}

	function _create_radiobox ($name, $value) {
		$opt = $this->_get_option();
		$checked = (wdsm_getval($opt, $name) == $value) ? true : false;
		return "<input type='radio' name='wdsm[{$name}]' id='{$name}-{$value}' value='{$value}' " . ($checked ? 'checked="checked" ' : '') . " /> ";
	}

	function create_javascript_box () {
		$wdsm = Wdsm_SocialMarketing::get_instance();
		echo __('Meine Webseite verwendet bereits Javascript von diesem Dienst:', 'wdsm') . '<br />';
		echo '<ul>';
		foreach ($wdsm->get_services() as $id=>$service) {
			$label = ucfirst($id);
			echo '<li>';
			echo "<label style='width: 100px; display: inline-block;' for='have_js-{$id}'>{$label}:</label> " . $this->_create_sub_checkbox('have_js', $id);
			echo $this->_help->add_tip(
				sprintf(__("Wähle &quot;Ja&quot; wenn Deine Seite bereits Skripte von %s enthalten", 'wdsm'), $label)
			);
			echo '</li>';
		}
		echo '</ul>';
	}
/*
	function create_popup_box () {
		echo "<p>" .
			'<span>' .
				$this->_create_radiobox('popup_box', 'thickbox') .
				'&nbsp;' .
				'<label for="popup_box-thickbox">' . __('Built-in WordPress Thickbox', 'wdsm') . '</label>' .
				$this->_help->add_tip(__("Thickbox is the default pop-up that ships with WordPress", 'wdsm')) .
			'</span>' .
		"<br />";
		echo "<span>".
			$this->_create_radiobox('popup_box', 'colorbox') .
			'&nbsp;' .
			'<label for="popup_box-colorbox">' . __('Colorbox', 'wdsm') . '</label>' .
			$this->_help->add_tip(__("Don't like the default pop-up? Try out colorbox", 'wdsm')) .
			'</span>' .
		"</p>";
		echo "<p>".
			'<label for="internal_colorbox-yes">' . __('My site already uses Colorbox (via theme or plugin)', 'wdsm') . '</label>' .
			'&nbsp;' .
			$this->_create_checkbox('internal_colorbox') .
			$this->_help->add_tip(__("Select &quot;Yes&quot; if you already have Colorbox-based pop-ups on your pages", 'wdsm')) .
		"</p>";
	}
*/	
	function create_theme_box () {
		$wdsm = Wdsm_SocialMarketing::get_instance();
		$_styles = $wdsm->get_styles();
		$default = $this->_get_option('theme');
		
		// Themes
		echo '<p><select id="wdsm-theme" name="wdsm[theme]">';
		foreach ($_styles as $style => $lbl) {
			$sel = ($style == $default) ? 'selected="selected"' : '';
			echo "<option value='{$style}' {$sel}>{$lbl}&nbsp;</option>";
		}
		echo '</select></p>';
		
		// No theme
		$check = (!$default) ? 'checked="checked"' : '';
		echo '<p>' .
			"<input type='checkbox' name='wdsm[theme]' id='wdsm-no-theme' value='' {$check} />" .
			'&nbsp;' .
			'<label for="wdsm-no-theme">' . __('Lade keine Stile, mein Thema enthält bereits alle Stile, die ich benötige', 'wdsm') . '</label>' .
			$this->_help->add_tip(__('Aktiviere diese Option, wenn Du Stile anstelle der Standardstile verwenden möchtest.', 'wdsm')) .
		'</p>';

		// Late binding
		echo '<div>' .
			'<label for="">' . __('Lazy Dependency Loading aktivieren?', 'wdsm') . '</label>&nbsp;' .
			$this->_create_checkbox('enable_late_binding') .
			$this->_help->add_tip(__('Das verzögerte Laden von Abhängigkeiten kann die Ladezeiten Deiner Seite verbessern, indem Ressourcen nach Bedarf geladen werden.', 'wdsm')) .
		'</div>';

		$wdsm = Wdsm_SocialMarketing::get_instance();
		$hook = esc_attr($wdsm->get_late_binding_hook());
		echo '<div>' .
			'<label for="wdsm-late_binding_hook">' . __('Lazy Ladehaken <small>(fortgeschritten)</small>:', 'wdsm') . '</label>&nbsp;' .
			'<input type="text" name="wdsm[late_binding_hook]" id="wdsm-late_binding_hook" value="' . $hook . '" />' .
			$this->_help->add_tip(__('Das verzögerte Laden von Abhängigkeiten hängt vom Fußzeilenhaken ab, um ordnungsgemäß bereitgestellt zu werden. Wenn Dein Design den Standard-Hook nicht implementiert, verwende dieses Feld, um Deinen benutzerdefinierten festzulegen.', 'wdsm')) .
		'</div>';
	}
	
	function create_getting_started_box () {
		echo '' .
			'<label for="show_getting_started-yes">' . __("Zeige &quot;Erste Schritte&quot; Seite auch nach Abschluss aller Schritte:", 'wdsm') . '</label>&nbsp;' .
			$this->_create_checkbox('show_getting_started') .
			$this->_help->add_tip(__('Standardmäßig wird die Seite &quot;Erste Schritte&quot; ausgeblendet, sobald Sie alle Schritte ausgeführt haben. Verwenden Sie diese Option, um dieses Verhalten zu steuern.', 'wdsm')) .
		'';
	}

}