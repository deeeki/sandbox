<?php
/*
Plugin Name: WP Mock Plugin
Plugin URI:
Description: description
Version: 0.1.0
Author: author name
Author URI:
Revision Date: Jan. 6, 2011
Tested up to: WordPress 3.0.3
*/

/**
 * abstract class
 */
abstract class AbstractPlugin {
	protected $_name = '';
	protected $_menu = '';
	private static $_MENUS = array(
		'management' => 'tools.php',
		'options' => 'options-general.php',
		'theme' => 'themes.php',
		'plugins' => 'plugins.php',
		'users' => 'profile.php',
		'dashboard' => 'index.php',
		'posts' => 'edit.php',
		'media' => 'upload.php',
		'links' => 'link-manager.php',
		'pages' => 'edit.php?post_type=page',
		'comments' => 'edit-comments.php',
	);

	/**
	 * constructor
	 */
	public function __construct() {
		if (!$this->_name) {
			$this->_name = get_class($this);
		}
		add_action('admin_menu', array(&$this, 'add_admin_menu'));
		add_filter('plugin_action_links', array(&$this, 'add_plugin_action_links'), 10, 2);
	}

	/**
	 * insert into admin menu
	 */
	public function add_admin_menu() {
		if (!$this->_menu) {
			$this->_menu = 'options';
		}
		$function = 'add_' . $this->_menu . '_page';
		call_user_func($function, $this->_name, $this->_name, 'administrator', plugin_basename(__FILE__), array($this, 'action'));
	}

	/**
	 * insert setting link into plugin page
	 */
	public function add_plugin_action_links($links, $file) {
		if ($file == plugin_basename(__FILE__) && isset(self::$_MENUS[$this->_menu])) {
			$link = self::$_MENUS[$this->_menu];
			$setting_link = '<a href="' . $link . '?page=' . plugin_basename(__FILE__) . '">' . __('Settings') . '</a>';
			array_unshift($links, $setting_link);
		}
		return $links;
	}

	/**
	 * action dispatcher
	 */
	public function action() {
		$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 'index';
		$action_method = 'action_' . $action;
		if (method_exists($this, $action_method)) {
			$this->$action_method();
		}
		else {
			echo 'error : action method [' . $action_method . '] not found';
		}
	}

	/**
	 * process action
	 */
	public function action_index() {
		$this->render_index();
	}

	/**
	 * render header
	 */
	public function render_header() {
		$setting_class = 'class="current"';
?>
	<h2><?php echo $this->_name ?></h2>

	<?php if (isset($this->message)): ?>
	<div id="message" class="updated fade"><p><font color="green"><?php echo $this->message ?></font></p></div>
	<?php endif; ?>
	<?php if (isset($this->error)): ?>
	<div id="error" class="updated fade"><p><font color="red"><?php echo $this->error ?></font></p></div>
	<?php endif; ?>
<?php
	}

	/**
	 * render navigation
	 */
	public function render_navigation() {
?>
	<ul class="subsubsub">
		<li><a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?page=<?php echo plugin_basename(__FILE__); ?>" <?php echo $setting_class ?>>Index</a></li>
	</ul>
	<div class="clear"></div>
<?php
	}

	/**
	 * render index page
	 */
	public function render_index() {
?>
<div class="wrap">
	<?php $this->render_header() ?>
	<?php $this->render_navigation() ?>
</div>
<?php
	}

	/**
	 * plugin activate hook
	 */
	public static function activate() {
	}

	/**
	 * plugin deactivate hook
	 */
	public static function deactivate() {
	}
}

/**
 * main class
 */
class MockPlugin extends AbstractPlugin {
	public $_name = 'MockPlugin';
	public $_menu = 'dashboard';

	public function action_index() {
		//write some process
		$this->render_index();
	}

	public function render_index() {
?>
<div class="wrap">
	<?php $this->render_header() ?>
	<?php $this->render_navigation() ?>
	write some view
</div>
<?php
	}
}

//main part. change your plugin name below.
if (is_admin()) {
	$MockPlugin = new MockPlugin();
	//register_activation_hook(__FILE__, array('MockPlugin', 'activate'));
	//register_deactivation_hook(__FILE__, array('MockPlugin', 'deactivate'));
}