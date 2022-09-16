<?php
/**
 * Type class
 *
 *
 * @author Gerry Demaret <gerry@tigron.be>
 * @author Christophe Gosiau <christophe@tigron.be>
 * @author David Vandemaele <david@tigron.be>
 */

namespace Skeleton\Package\Cms\Email;

use Skeleton\Database\Database;

class Type {
	use \Skeleton\Object\Get;
	use \Skeleton\Pager\Page;
	use \Skeleton\Object\Model;
	use \Skeleton\Object\Delete {
		delete as trait_delete;
	}
	use \Skeleton\Object\Save;

	private static $class_configuration = [
	  'database_table' => 'email_type',
	];

	/**
	 * delete
	 *
	 * @access public
	 */
	public function delete() {
		$emails = \Skeleton\Package\Cms\Email\Email::get_by_email_type($this);
		foreach ($emails as $email) {
			$email->delete();
		}
		$this->trait_delete();
	}

	/**
	 * Get email by language
	 *
	 * @access public
	 * @param \Skeleton\Package\Cms\Email\Type $type
	 * @param $language
	 * @return \Skeleton\Package\Cms\Email\Email
	 */
	public function get_email_by_language($language) {
		try {
			$email = \Skeleton\Package\Cms\Email\Email::get_by_email_type_language($this, $language);
		} catch (\Exception $e) {
			$email = new \Skeleton\Package\Cms\Email\Email();
			$email->email_type_id = $this->id;
			$email->language_id = $language->id;
			$email->save();
		}
		return $email;
	}

	/**
	 * Get email by identifier
	 *
	 * @access public
	 * @param string $identifier
	 * @return \Skeleton\Package\Cms\Email\Email
	 */
	public static function get_by_identifier($identifier) {
		$db = Database::get();
		$id = $db->get_one('SELECT id FROM email_type WHERE identifier=?', [ $identifier ]);
		if ($id === null) {
			throw new \Exception('Email type not found');
		}

		return self::get_by_id($id);
	}

}
