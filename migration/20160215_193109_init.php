<?php
/**
 * Database migration class
 *
 * @author Gerry Demaret <gerry@tigron.be>
 * @author Christophe Gosiau <christophe@tigron.be>
 * @author David Vandemaele <david@tigron.be>
 */
namespace Skeleton\Package\Cms\Email;
use \Skeleton\Database\Database;

class Migration_20160215_193109_Init extends \Skeleton\Database\Migration {

	/**
	 * Migrate up
	 *
	 * @access public
	 */
	public function up() {
		$db = Database::get();
		$db->query('
			CREATE TABLE `email` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `language_id` int(11) NOT NULL,
			  `email_type_id` int(11) NOT NULL,
			  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `text` text COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `language_id` (`language_id`),
			  KEY `email_type_id` (`email_type_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		', []);

		$db->query('
			CREATE TABLE `email_type` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
			  `short_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
			  `identifier` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
			  `removable` tinyint(1) NOT NULL,
			  `variables` text COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `short_name` (`short_name`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		', []);
	}

	/**
	 * Migrate down
	 *
	 * @access public
	 */
	public function down() {

	}
}
