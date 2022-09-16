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
	use \Skeleton\Object\Delete {
		delete as trait_delete;
	}
	use \Skeleton\Object\Save;

	private static $class_configuration = [
	  'database_table' => 'email',
	];

	/**
	 * delete
	 *
	 * @access public
	 */
	public function delete() {
		foreach ($this->get_email_files() as $email_file) {
			$email_file->delete();
		}
		$this->trait_delete();
	}

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
	 * Get all email_files
	 *
	 * @access public
	 * @return array email_files
	 */
	public function get_email_files() {
		return File::get_by_email($this);
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

	/**
	 * Get an email by Email_Type
	 *
	 * @access public
	 * @param Email_Type
	 * @return Email
	 */
	public static function get_by_email_type(Type $type) {
		$db = Database::Get();
		$results = [];
		$ids = $db->get_column('SELECT id FROM email WHERE email_type_id=?', [$type->id]);
		foreach ($ids as $id) {
			$results[] = self::get_by_id($id);
		}
		return $results;
	}
}
