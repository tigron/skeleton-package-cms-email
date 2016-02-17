<?php
/**
 * Module Login
 *
 * @author Christophe Gosiau <christophe@tigron.be>
 * @author David Vandemaele <david@tigron.be>
 * @author Gerry Demaret <gerry@tigron.be>
 */

namespace Skeleton\Package\Cms\Email\Web\Module;

use \Skeleton\Pager\Web\Pager;
use \Skeleton\Core\Web\Template;
use \Skeleton\Core\Web\Session;
use \Skeleton\Package\Crud\Web\Module\Crud;
use \Skeleton\Package\Cms\Email\Type;

abstract class Cms extends Crud {

	/**
	 * Login required ?
	 * Default = yes
	 *
	 * @access public
	 * @var bool $login_required
	 */
	public $login_required = false;

	/**
	 * Template to use
	 *
	 * @access public
	 * @var string $template
	 */
	public $template = '@skeleton-package-crud\content.twig';

	/**
	 * Edit
	 *
	 * @access public
	 */
	public function display_edit() {
		$template = Template::get();

		$object = Type::get_by_id($_GET['id']);
		$template->assign('object', $object);

		if (isset($_POST['object'])) {
			$object->load_array($_POST['object']);
			$object->save();
			Session::set_sticky('updated', true);
			Session::redirect($this->get_module_path() . '?action=edit&id=' . $object->id);
		}

		$interface = \Skeleton\I18n\Config::$language_interface;
		$languages = $interface::get_all();
		$template->assign('languages', $languages);

	}

	/**
	 * Markdown to html
	 *
	 * @access public
	 */
	public function display_markdown_to_html() {
		$parser = new \Michelf\MarkdownExtra();
		$output = $parser->transform($_POST['markdown']);
		echo $output;
		$this->template = false;
	}

	/**
	 * Update an email
	 *
	 * @access public
	 */
	public function display_update_email() {
		parse_str($_POST['data'], $data);
		$email_type = Type::get_by_id($_POST['email_type_id']);
		$interface = \Skeleton\I18n\Config::$language_interface;
		$language = $interface::get_by_name_short($_POST['language']);
		$email = $email_type->get_email_by_language($language);
		$email->load_array($data['email']);
		$email->save();
		$this->template = false;
	}

	/**
	 * Get pager
	 *
	 * @access public
	 * @return Skeleton\Pager\Web\Pager $pager
	 */
	public function get_pager() {
		$pager = new Pager('Skeleton\Package\Cms\Email\Type');
		$pager->add_sort_permission('id');
		$pager->add_sort_permission('name');

		return $pager;
	}


}
