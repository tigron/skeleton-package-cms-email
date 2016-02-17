<?php
/**
 * Email class
 *
 *
 * @author Gerry Demaret <gerry@tigron.be>
 * @author Christophe Gosiau <christophe@tigron.be>
 * @author David Vandemaele <david@tigron.be>
 */

namespace Skeleton\Package\Cms\Email;

use Skeleton\Database\Database;

class Email {
	use \Skeleton\Object\Get;
	use \Skeleton\Pager\Page;
	use \Skeleton\Object\Model;
	use \Skeleton\Object\Delete;
	use \Skeleton\Object\Save;

	private static $class_configuration = [
	  'database_table' => 'email',
	];

	/**
	 * Render a field (markdown)
	 *
	 * @access public
	 * @return string $html
	 */
	public function render($field) {
		$parser = new \Michelf\MarkdownExtra();
		$output = $parser->transform($this->$field);
		return $output;
	}

	/**
	 * Get an email by Email_Type and language
	 *
	 * @param Email_Type
	 * @param Language
	 * @access public
	 * @return Email
	 */
	public static function get_by_email_type_language(Type $type, \Skeleton\I18n\LanguageInterface $lang) {
		$db = Database::Get();
		$id = $db->get_one('SELECT id FROM email WHERE email_type_id=? AND language_id=?', [$type->id, $lang->id]);
		if ($id === null) {
			throw new \Exception('Email not found');
		}
		return Email::get_by_id($id);
	}

}
