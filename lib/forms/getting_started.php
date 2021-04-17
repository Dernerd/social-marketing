<div id="wdsm-plugin-setting" class="wrap">
<?php screen_icon(); ?>
<h2><?php _e('Erste Schritte', 'wdsm');?></h2>

<div class="metabox-holder">
	
	<!-- Erste Schritte box -->
	<div class="postbox">
		<h3 class="hndle"><span><?php _e('Erste Schritte', 'wdsm'); ?></span></h3>
		<div class="inside">
			<div class="note">
				<p><?php _e('Willkommen im Social Marketing Erste Schritte.', 'wdsm'); ?></p>
			</div>
			<p><?php echo '' . 
				'<p>' . __('Mit Social Marketing kannst Du eine Menge Interesse an Deinem Produkt oder Deiner Dienstleistung wecken, indem Du die wahre Kraft sozialer Netzwerke nutzt.', 'wdsm') . '</p>' .
				'<ul>' .
					'<li>' . __('Besucher werden durch einen <b>Gutschein, einen Rabattcode, einen Download</b> oder einen anderen Anreiz verführt', 'wdsm') . '</li>' .
					'<li>' . __('Durch einfaches Liken auf Facebook, Retweeten, Erwähnen auf LinkedIn wird der Anreiz freigeschaltet', 'wdsm') . '</li>' .
					'<li>' . __('Füge Dein Marketing einfach über eine <b>einfache Schaltfläche</b> im WordPress-Editor zu jedem Beitrag/jeder Seite hinzu', 'wdsm') . '</li>' .
				'</ul>' .
			''; ?></p>
			<ol class="wdsm-steps">
				<li>
					<?php if (wdsm_getval($wdsm_tutorial, 'settings')) { ?>
						<span class="wdsm_del">
					<?php } ?>
						<?php _e('Zunächst musst Du Deine Einstellungen konfigurieren. Hier kannst Du das Verhalten und das Erscheinungsbild Deiner Anzeigen festlegen.', 'wdsm'); ?>					
					<?php if (wdsm_getval($wdsm_tutorial, 'settings')) { ?>
						</span>
					<?php } ?> 
					<a href="admin.php?page=wdsm-get_started&intent=settings" class="button"><?php _e('Konfiguriere Deine Einstellungen', 'wdsm'); ?></a>
				</li>
				<li>
					<?php if (wdsm_getval($wdsm_tutorial, 'add')) { ?>
						<span class="wdsm_del">
					<?php } ?>
						<?php _e('Erstelle als Nächstes eine neue Anzeige. ', 'wdsm'); ?>					
					<?php if (wdsm_getval($wdsm_tutorial, 'add')) { ?>
						</span>
					<?php } ?> 
					<a href="admin.php?page=wdsm-get_started&intent=add" class="button"><?php _e('Anzeige erstellen', 'wdsm'); ?></a>
				</li>
				<li>
					<?php if (wdsm_getval($wdsm_tutorial, 'insert')) { ?>
						<span class="wdsm_del">
					<?php } ?>
						<?php _e('Füge zum Schluss Deine Anzeige in einen Beitrag ein.', 'wdsm'); ?>					
					<?php if (wdsm_getval($wdsm_tutorial, 'insert')) { ?>
						</span>
					<?php } ?> 
					<a href="admin.php?page=wdsm-get_started&intent=insert" class="button"><?php _e('In Beitrag einfügen', 'wdsm'); ?></a>
				</li>
			</ol>
		</div>
	</div>
	
<?php if (!defined('PSOURCE_REMOVE_BRANDING') || !constant('PSOURCE_REMOVE_BRANDING')) { ?>
	<!-- More Help box -->
	<div class="postbox">
		<h3 class="hndle"><span><?php _e('Benötigst Du weitere Hilfe?', 'wdsm'); ?></span></h3>
		<div class="inside">
			<ul>
				<li><a href="https://n3rds.work/piestingtal-source-project/ps-social-marketing/" target="_blank"><?php _e('Plugin Projektseite', 'wdsm'); ?></a></li>
				<!--<li><a href="#" target="_blank"><?php _e('Video tutorial', 'wdsm'); ?></a></li>-->
				<li><a href="https://n3rds.work/nw-forum/" target="_blank"><?php _e('Support forum', 'wdsm'); ?></a></li>
			</ul>
		</div>
	</div>
<?php } ?>
</div>

</div>