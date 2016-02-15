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
	use \Skeleton\Object\Delete;
	use \Skeleton\Object\Save;

	private static $class_configuration = [
	  'database_table' => 'email_type',
	];

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

}
