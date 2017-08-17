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

class Migration_20160223_155246_File extends \Skeleton\Database\Migration {

	/**
	 * Migrate up
	 *
	 * @access public
	 */
	public function up() {
		$db = Database::get();
		$db->query('
			CREATE TABLE `email_file` (
				`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`email_id` int NOT NULL,
				`file_id` int NOT NULL
			);
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
