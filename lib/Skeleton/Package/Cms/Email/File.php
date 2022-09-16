<?php
/**
 * Email File class
 *
 * @author Gerry Demaret <gerry@tigron.be>
 * @author Christophe Gosiau <christophe@tigron.be>
 * @author David Vandemaele <david@tigron.be>
 */

namespace Skeleton\Package\Cms\Email;

use Skeleton\Database\Database;

class File {
	use \Skeleton\Object\Get;
	use \Skeleton\Object\Delete {
		delete as trait_delete;
	}
	use \Skeleton\Object\Save;
	use \Skeleton\Object\Model {
		__isset as trait_isset;
		__get as trait_get;
	}

	private static $class_configuration = [
		'database_table' => 'email_file',
	];

	/**
	 * delete
	 *
	 * @access public
	 */
	public function delete() {
		\Skeleton\File\File::get_by_id($this->file_id)->delete();
		$this->trait_delete();
	}

	/**
	 * get file
	 *
	 * @access public
	 * @return File
	 */
	public function get_file() {
		return \Skeleton\File\File::get_by_id($this->file_id);
	}

	/**
	 * Get all files for a given Email
	 *
	 * @access public
	 * @param Email $email
	 * @return array $email_files
	 */
	public static function get_by_email(Email $email) {
		$db = Database::get();
		$ids = $db->get_column('SELECT id FROM email_file WHERE email_id = ?', [ $email->id ]);
		$email_files = [];
		foreach ($ids as $id){
			$email_files[] = self::get_by_id($id);
		}
		return $email_files;
	}
}
