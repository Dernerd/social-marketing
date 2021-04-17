<?php
/**
 * Social Marketing contextual help implementation.
 */

class Wdsm_ContextualHelp {
	
	private $_help;
	
	private $_pages = array(
		'list', 'edit', 'get_started', 'settings',
	);
	
	private $_social_marketing_sidebar = '';
	
	private function __construct () {
		if (!class_exists('Psource_ContextualHelp')) require_once WDSM_PLUGIN_BASE_DIR . '/lib/external/class_wd_contextual_help.php';
		$this->_help = new Psource_ContextualHelp();
		$this->_set_up_sidebar();
	}
	
	public static function serve () {
		$me = new Wdsm_ContextualHelp;
		$me->_initialize();
	}
	
	private function _set_up_sidebar () {
		$this->_social_marketing_sidebar = '<h4>' . __('Social Marketing', 'wdsm') . '</h4>';
		if (defined('PSOURCE_REMOVE_BRANDING') && constant('PSOURCE_REMOVE_BRANDING')) {
			$this->_social_marketing_sidebar .= '<p>' . __('Mit Social Marketing kannst Du eine Menge Interesse an Deinem Produkt oder Deiner Dienstleistung wecken, indem Du die wahre Kraft sozialer Netzwerke nutzt.', 'wdsm') . '</p>';
		} else {
				$this->_social_marketing_sidebar .= '<ul>' .
					'<li><a href="https://n3rds.work/piestingtal-source-project/ps-social-marketing/" target="_blank">' . __('Projektseite', 'wdsm') . '</a></li>' .
					'<li><a href="https://n3rds.work/nw-forum/" target="_blank">' . __('Support Forum', 'wdsm') . '</a></li>' .
				'</ul>' . 
			'';
		}
	}
	
	private function _initialize () {
		foreach ($this->_pages as $page) {
			$method = "_add_{$page}_page_help";
			if (method_exists($this, $method)) $this->$method();
		}
		$this->_help->initialize();
	}
	
	private function _add_list_page_help () {
		$this->_help->add_page(
			'edit-social_marketing_ad',
			array(
				array(
					'id' => 'wdsm-intro',
					'title' => __('Übersicht', 'wdsm'),
					'content' => '<p>' . __('Deine vorhandenen Social Marketing-Anzeigen werden hier aufgelistet.', 'wdsm') . '</p>',
				),
				array(
					'id' => 'wdsm-general',
					'title' => __('Allgemeine Information', 'wdsm'),
					'content' => '' .
						'<p>' . __('Mit Social Marketing kannst Du eine Menge Interesse an Deinem Produkt oder Deiner Dienstleistung wecken, indem Du die wahre Kraft sozialer Netzwerke nutzt.', 'wdsm') . '</p>' .
						'<p><b>' . __('Verwendung von Social Marketing auf Deiner Website:', 'wdsm') . '</b></p>' .
						'<ul>' .
							'<li>' . __('Besucher werden durch einen <b>Gutschein, einen Rabattcode, einen Download</b> oder einen anderen Anreiz verführt', 'wdsm') . '</li>' .
							'<li>' . __('Durch einfaches Liken auf Facebook, Retweeten, Erwähnen auf Instagram oder LinkedIn wird der Anreiz freigeschaltet', 'wdsm') . '</li>' .
							'<li>' . __('Füge Dein Marketing einfach über eine <b>einfache Schaltfläche</b> im WordPress-Editor zu jedem Beitrag/jeder Seite hinzu', 'wdsm') . '</li>' .
						'</ul>' .
						'<p>' . sprintf(__('Mit dem <a href="%s"> Erste Schritte-Handbuch kannst Du schnell loslegen</a>', 'wdsm'), admin_url('admin.php?page=wdsm-get_started')) . '</p>' .
					''
				),
				array(
					'id' => 'wdsm-available_actions',
					'title' => __('Mögliche Aktionen', 'wdsm'),
					'content' => '' .
						'<p>' . __('Wenn Du den Mauszeiger über eine Zeile in der Anzeigenliste bewegst, werden Aktionslinks angezeigt, mit denen Du Deine Anzeige verwalten kannst. Du kannst die folgenden Aktionen ausführen:', 'wdsm') . '</p>' .
						'<ul>' .
							'<li>' . __('<b>Bearbeiten</b> führt Dich zum Bearbeitungsbildschirm für diese Anzeige. Du kannst diesen Bildschirm auch erreichen, indem Du auf den Titel des Beitrags klickst.', 'wdsm') . '</li>' .
							'<li>' . __('<b>Schnellbearbeitung</b> bietet Inline-Zugriff auf die Metadaten Deiner Anzeige, sodass Du die Anzeigendetails aktualisieren kannst, ohne diesen Bildschirm zu verlassen.', 'wdsm') . '</li>' .
							'<li>' . __('<b>Papierkorb</b> entfernt Deine Anzeige aus dieser Liste und legt sie in den Papierkorb, aus dem Du sie dauerhaft löschen kannst.', 'wdsm') . '</li>' .
							'<li>' . __('<b>Vorschau</b> zeigt Dir, wie Dein Anzeigenentwurf aussehen wird, wenn Du ihn veröffentlichst. Mit Ansehen gelangst Du zu Deiner Live-Site, um die Anzeige anzuzeigen. Welcher Link verfügbar ist, hängt vom Status Deiner Anzeige ab.', 'wdsm') . '</li>' .
						'</ul>' .
					''
				),
				array(
					'id' => 'wdsm-bulk_actions',
					'title' => __('Massenaktionen', 'wdsm'),
					'content' => '' .
						'<p>' . __('Du kannst auch mehrere Anzeigen gleichzeitig bearbeiten oder in den Papierkorb verschieben. Wähle die Anzeigen, auf die Du reagieren möchtest, über die Kontrollkästchen aus, wähle dann im Menü "Massenaktionen" die Aktion aus, die Du ausführen möchtest, und klicke auf "Übernehmen".', 'wdsm') . '</p>' .
						'<p>' . __('Bei Verwendung der Massenbearbeitung kannst Du den Status mehrerer Anzeigen gleichzeitig ändern. Dies kann nützlich sein, wenn Du mehrere Anzeigen gleichzeitig verfügbar machen möchtest.', 'wdsm') . '</p>' .
					''
				),
			),
			$this->_social_marketing_sidebar,
			true
		);
	}
	private function _add_edit_page_help () {
		$this->_help->add_page(
			'social_marketing_ad',
			array(
				array(
					'id' => 'wdsm-intro',
					'title' => __('Übersicht', 'wdsm'),
					'content' => '' .
							'<p>' . 
								__('Hier kannst Du eine Social Marketing-Anzeige bearbeiten oder erstellen.', 'wdsm') . 
							'</p>' . 
						'',
					),
				array(
					'id' => 'wdsm-general',
					'title' => __('Allgemeine Information', 'wdsm'),
					'content' => '' .
						'<p>' . __('Mit Social Marketing kannst Du eine Menge Interesse an Deinem Produkt oder Deinen Dienstleistung wecken, indem Du die wahre Kraft sozialer Netzwerke nutzt.', 'wdsm') . '</p>' .
						'<p><b>' . __('Verwenden von Social Marketing auf Deiner Website:', 'wdsm') . '</b></p>' .
						'<ul>' .
							'<li>' . __('Besucher werden durch einen <b>Gutschein, einen Rabattcode, einen Download</b> oder einen anderen Anreiz verführt', 'wdsm') . '</li>' .
							'<li>' . __('Durch einfaches Liken auf Facebook, Retweeten, Erwähnen auf LinkedIn wird der Anreiz freigeschaltet', 'wdsm') . '</li>' .
							'<li>' . __('Füge Dein Marketing einfach über eine <b>einfache Schaltfläche</b> im WordPress-Editor zu jedem Beitrag/jeder Seite hinzu', 'wdsm') . '</li>' .
						'</ul>' .
						'<p>' . sprintf(__('Mit den <a href="%s">Ersten Schritte</a> kannst Du schnell loslegen', 'wdsm'), admin_url('admin.php?page=wdsm-get_started')) . '</p>' .
					''
				),
				array(
					'id' => 'wdsm-creation',
					'title' => __('Anzeigenerstellung', 'wdsm'),
					'content' => '' .
						'<p>' . __('<b>Titel</b> - Gib einen Titel für Dein Marketing ein. Nachdem Du einen Titel eingegeben hast, wird unten der Permalink angezeigt, den Du bearbeiten kannst.', 'wdsm') . '</p>' .
						'<p>' . __('<b>Anzeigeneditor</b> - Gib den Text für Deine Anzeige ein. Es gibt zwei Bearbeitungsmodi: Visual und HTML. Wähle den Modus, indem Du auf die entsprechende Registerkarte klickst. Im visuellen Modus erhältst Du einen WYSIWYG-Editor. Klicke auf das letzte Symbol in der Reihe, um eine zweite Reihe von Steuerelementen zu erhalten. Im HTML-Modus kannst Du Roh-HTML zusammen mit Deinem Anzeigentext eingeben. Du kannst Mediendateien einfügen, indem Du auf die Symbole über dem Anzeigeneditor klickst und den Anweisungen folgst. Du kannst zum ablenkungsfreien Schreibbildschirm über das Vollbildsymbol im visuellen Modus (vorletzter in der oberen Reihe) oder die Vollbildschaltfläche im HTML-Modus (letzter in der Reihe) wechseln. Dort kannst Du Schaltflächen sichtbar machen, indem Du den Mauszeiger über den oberen Bereich bewegst. Beende Fullscreen zurück zum regulären Anzeigeneditor.', 'wdsm') . '</p>' .
						'<p>' . __('<b>Veröffentlichen</b> - Du kannst die Bedingungen für die Veröffentlichung Deiner Anzeige im Feld Veröffentlichen festlegen. Für beste Ergebnisse empfehlen wir, diese auf ihren Standardeinstellungen zu belassen. Durch das Veröffentlichen Deiner Anzeige wird diese nicht sofort sichtbar. Es wird nur als Shortcode verfügbar gemacht, den Du dann in einen beliebigen Beitrag, eine Seite oder einen benutzerdefinierten Beitragstyp einfügen kannst.', 'wdsm') . '</p>' .
					''
				),
				array(
					'id' => 'wdsm-tutorial',
					'title' => __('Tutorial', 'wdsm'),
					'content' => '' .
						'<p>' . 
							__('Tutorial-Dialoge führen Dich durch die wichtigen Punkte.', 'wdsm') . 
						'</p>' .
						'<p><a href="#" class="wdsm-restart_tutorial" data-wdsm_tutorial="edit">' . __('Starte das Tutorial neu', 'wdsm') . '</a></p>',
				),
			),
			$this->_social_marketing_sidebar,
			true
		);		
	}
	private function _add_get_started_page_help () {
		$this->_help->add_page(
			'social_marketing_ad_page_wdsm-get_started',
			array(
				array(
					'id' => 'wdsm-intro',
					'title' => __('Übersicht', 'wdsm'),
					'content' => '<p>' . __('Dies ist der Leitfaden für den Einstieg in das Plugin <b>Social Marketing</b>', 'wdsm') . '</p>',
				),
				array(
					'id' => 'wdsm-general',
					'title' => __('Allgemeine Information', 'wdsm'),
					'content' => '' .
						'<p>' . __('Mit Social Marketing kannst Du eine Menge Interesse an Deinem Produkt oder Deiner Dienstleistung wecken, indem Du die wahre Kraft sozialer Netzwerke nutzt.', 'wdsm') . '</p>' .
						'<p><b>' . __('Verwenden von Social Marketing auf Deiner Webseite:', 'wdsm') . '</b></p>' .
						'<ul>' .
							'<li>' . __('Besucher werden durch einen <b>Gutschein, einen Rabattcode, einen Download</b> oder einen anderen Anreiz verführt', 'wdsm') . '</li>' .
							'<li>' . __('Durch einfaches Liken auf Facebook, Retweeten, Erwähnen auf LinkedIn wird der Anreiz freigeschaltet', 'wdsm') . '</li>' .
							'<li>' . __('Füge Dein Marketing einfach über eine <b>einfache Schaltfläche</b> im WordPress-Editor zu jedem Beitrag/jeder Seite hinzu', 'wdsm') . '</li>' .
						'</ul>' .
						'<p>' . sprintf(__('Mit den <a href="%s">Ersten Schritte</a> kannst Du schnell loslegen', 'wdsm'), admin_url('admin.php?page=wdsm-get_started')) . '</p>' .
					''
				),
				array(
					'id' => 'wdsm-steps',
					'title' => __('Leitfaden', 'wdsm'),
					'content' => '<p>' . __('Bitte gehe die Schritte durch, um Dein Plugin-Setup abzuschließen und dich zurechtzufinden', 'wdsm') . '</p>',
				),
			),
			$this->_social_marketing_sidebar,
			true
		);				
	}
	private function _add_settings_page_help () {
		$this->_help->add_page(
			'social_marketing_ad_page_wdsm',
			array(
				array(
					'id' => 'wdsm-intro',
					'title' => __('Übersicht', 'wdsm'),
					'content' => '<p>' . __('Hier konfigurierst Du das Plugin <b>Social Marketing</b> für Deine Site', 'wdsm') . '</p>',
				),
				array(
					'id' => 'wdsm-general',
					'title' => __('Allgemeine Information', 'wdsm'),
					'content' => '' .
						'<p>' . __('Mit Social Marketing kannst Du eine Menge Interesse an Deinem Produkt oder Deiner Dienstleistung wecken, indem Du die wahre Kraft sozialer Netzwerke nutzt.', 'wdsm') . '</p>' .
						'<p><b>' . __('Verwenden von Social Marketing auf Deiner Webseite:', 'wdsm') . '</b></p>' .
						'<ul>' .
							'<li>' . __('Besucher werden durch einen <b>Gutschein, einen Rabattcode, einen Download</b> oder einen anderen Anreiz verführt', 'wdsm') . '</li>' .
							'<li>' . __('Durch einfaches Liken auf Facebook, Retweeten, Erwähnen auf LinkedIn wird der Anreiz freigeschaltet', 'wdsm') . '</li>' .
							'<li>' . __('Füge Dein Marketing einfach über eine <b>einfache Schaltfläche</b> im WordPress-Editor zu jedem Beitrag/jeder Seite hinzu', 'wdsm') . '</li>' .
						'</ul>' .
						'<p>' . sprintf(__('Mit den <a href="%s">Ersten Schritte</a> kannst Du schnell loslegen', 'wdsm'), admin_url('admin.php?page=wdsm-get_started')) . '</p>' .
					''
				),
				array(
					'id' => 'wdsm-javascript',
					'title' => __('Javascript', 'wdsm'),
					'content' => '' . 
							'<p>' . __('Wenn Deine Seite bereits Javascripts von einem oder mehreren der unterstützten Dienste verwendet, sage dies hier, um Konflikte zu vermeiden.', 'wdsm') . '</p>' .
						'',
				),
				array(
					'id' => 'wdsm-tutorial',
					'title' => __('Tutorial', 'wdsm'),
					'content' => '' .
						'<p>' . 
							__('Tutorial-Dialoge führen Dich durch die wichtigen Punkte.', 'wdsm') . 
						'</p>' .
						'<p><a href="#" class="wdsm-restart_tutorial" data-wdsm_tutorial="setup">' . __('Starte das Tutorial neu', 'wdsm') . '</a></p>',
				),
			),
			$this->_social_marketing_sidebar,
			true
		);	
	}
}
