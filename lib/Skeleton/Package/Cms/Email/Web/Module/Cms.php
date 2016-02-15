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

		$interface = \Skeleton\I18n\Config::$language_interface;
		$languages = $interface::get_all();
		$template->assign('languages', $languages);

	}

	/**
	 * Get pager
	 *
	 * @access public
	 * @return Skeleton\Pager\Web\Pager $pager
	 */
	public function get_pager() {
		$pager = new Pager('Skeleton\Package\Cms\Email\Type');
		return $pager;
	}


}
