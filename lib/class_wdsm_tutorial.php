<?php

class Wdsm_Tutorial {
	
	private $_edit_tutorial;
	private $_setup_tutorial;
	private $_insert_tutorial;
	
	private $_edit_steps = array(
		'welcome',
		'title',
		'body',
		'options',
		'share_url',
		'button_text',
		'type',
		'share_text',
		'services',
	);
	
	private $_setup_steps = array(
		'settings',
		//'popup',
		'javascript',
		'appearance',
		'styles',
	);

	private $_insert_steps = array(
		'insert',
	);
	
	private function __construct () {
		if (!class_exists('Pointer_Tutorial')) require_once WDSM_PLUGIN_BASE_DIR . '/lib/external/pointers_tutorial.php';
		$this->_edit_tutorial = new Pointer_Tutorial('wdsm-edit', __('Social Marketing Tutorial', 'wdsm'), false, false);
		$this->_setup_tutorial = new Pointer_Tutorial('wdsm-setup', __('Setup-Tutorial', 'wdsm'), false, false);
		$this->_insert_tutorial = new Pointer_Tutorial('wdsm-insert', __('Einfügen Tutorial', 'wdsm'), false, false);
		$this->_edit_tutorial->add_icon(WDSM_PLUGIN_URL . '/img/pointer_icon.png');
		$this->_setup_tutorial->add_icon(WDSM_PLUGIN_URL . '/img/pointer_icon.png');
		$this->_insert_tutorial->add_icon(WDSM_PLUGIN_URL . '/img/pointer_icon.png');
	} 
	
	public static function serve () {
		$me = new Wdsm_Tutorial;
		$me->_add_hooks();
	}
	
	private function _add_hooks () {
		add_action('admin_init', array($this, 'process_tutorial'));
		add_action('wp_ajax_wdsm_restart_tutorial', array($this, 'json_restart_tutorial'));
	}
	
	function process_tutorial () {
		global $pagenow;
		if ('wdsm' == wdsm_getval($_GET, 'page')) $this->_init_tutorial($this->_setup_steps);
		if ('social_marketing_ad' == wdsm_getval($_GET, 'post_type') && 'post-new.php' == $pagenow) $this->_init_tutorial($this->_edit_steps);
		if ('first' == wdsm_getval($_GET, 'wdsm') && 'post-new.php' == $pagenow) $this->_init_tutorial($this->_insert_steps);
		if (defined('DOING_AJAX')) {
			$this->_init_tutorial($this->_setup_steps);
			$this->_init_tutorial($this->_edit_steps);
		}
		$this->_edit_tutorial->initialize();
		$this->_setup_tutorial->initialize();
		$this->_insert_tutorial->initialize();
	}
	
	function json_restart_tutorial () {
		$tutorial = @$_POST['tutorial'];
		$this->restart($tutorial);
		die;
	}
	
	public function restart ($part=false) {
		$tutorial = "_{$part}_tutorial";
		if ($part && isset($this->$tutorial)) return $this->$tutorial->restart();
		else if (!$part) {
			$this->_edit_tutorial->restart();
			$this->_setup_tutorial->restart();
		}
	} 
	
	private function _init_tutorial ($steps) {
		$this->_edit_tutorial->set_textdomain('wdsm');
		$this->_edit_tutorial->set_textdomain('wdsm');
		$this->_setup_tutorial->set_capability('manage_options');
		$this->_setup_tutorial->set_capability('manage_options');
		
		foreach ($steps as $step) {
			$call_step = "add_{$step}_step";
			if (method_exists($this, $call_step)) $this->$call_step();
		}
	}
	
/* ----- Edit Steps ----- */

	function add_welcome_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#icon-edit',
			__('Neue Anzeige', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Hier erstellst Du&#8217; Deine erste Social-Marketing-Anzeige!', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
		
	}

	function add_title_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#title',
			__('Titel', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Gib Deiner Anzeige einen Titel.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
		
	}

	function add_body_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#postdivrich',
			__('Verkaufe Dein Produkt', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Sage Deinen Besuchern, warum sie auf Deine Anzeige klicken sollten!', 'wdsm')) . '</p>',
				'position' => array('edge' => 'bottom', 'align' => 'left'),
			)
		);
		
	}
	
	function add_options_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#wdsm_services',
			__('Social Marketing Optionen', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Hier kannst Du die meisten Deiner Optionen optimieren.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'bottom', 'align' => 'left'),
			)
		);
		
	}

	function add_share_url_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#wdsm_url',
			__('URL', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Dies ist die URL, die Deine Besucher mit ihren Freunden teilen.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}

	function add_button_text_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#wdsm_button_text',
			__('Schaltflächentext', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Füge einen Aufruf zum Handeln hinzu, damit Deine Besucher klicken!', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}

	function add_type_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#wdsm_type',
			__('Angebotsart', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Wähle ob Du einen kostenlosen Download oder einen Gutscheincode anbietest.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}

	function add_share_text_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#wdsm_share_text',
			__('Dankeschön Text', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Vielen Dank an Deine Benutzer für das Klicken auf Deinen Link.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}

	function add_services_step () {	
		$this->_edit_tutorial->add_step(
			admin_url('post-new.php?post_type=social_marketing_ad'), 'post-new.php',
			'#wdsm-services_box',
			__('Sozialen Medien', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Wähle einen oder mehrere Social Media-Dienste aus.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'bottom', 'align' => 'left'),
			)
		);
	}
	
/* ----- Setup Steps ----- */
	
	function add_settings_step () {
		$this->_setup_tutorial->add_step(
			admin_url('edit.php?post_type=social_marketing_ad&page=wdsm'), 'social_marketing_ad_page_wdsm',
			'#wdsm-settings_start',
			__('Willkommen!', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Hier erstellst Du&#8217;Deine erste Social-Marketing-Anzeige.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}
/*
	function add_popup_step () {
		$this->_setup_tutorial->add_step(
			admin_url('edit.php?post_type=social_marketing_ad&page=wdsm'), 'social_marketing_ad_page_wdsm',
			'#settings-pop-up-box',
			__('Pop-up style', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Choose how your pop-up advert will be displayed. ', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}
*/
	function add_javascript_step () {
		$this->_setup_tutorial->add_step(
			admin_url('edit.php?post_type=social_marketing_ad&page=wdsm'), 'social_marketing_ad_page_wdsm',
			'#settings-javascript',
			__('Javascript', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Wähle alle Dienste aus, die bereits Javascript für Deine Webseite bereitstellen.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}

	function add_appearance_step () {
		$this->_setup_tutorial->add_step(
			admin_url('edit.php?post_type=social_marketing_ad&page=wdsm'), 'social_marketing_ad_page_wdsm',
			'#wdsm-theme',
			__('Aussehen', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Wähle aus, wie Deine Schaltfläche aussehen soll.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}

	function add_styles_step () {
		$this->_setup_tutorial->add_step(
			admin_url('edit.php?post_type=social_marketing_ad&page=wdsm'), 'social_marketing_ad_page_wdsm',
			'#wdsm-no-theme',
			__('Styles', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Wenn Du die Schaltfläche selbst gestalten möchtest, aktiviere dieses Kontrollkästchen.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'top', 'align' => 'left'),
			)
		);
	}

/* ----- Insert ----- */

	function add_insert_step () {
		$this->_insert_tutorial->add_step(
			admin_url('post-new.php'), 'post-new.php',
			'#add_advert',
			__('Anzeige einfügen', 'wdsm'),
			array(
				'content' => '<p>' . esc_js(__('Klicke auf dieses Symbol, um Deine Social Marketing-Anzeige einzufügen.', 'wdsm')) . '</p>',
				'position' => array('edge' => 'left', 'align' => 'left'),
			)
		);
	}


}
