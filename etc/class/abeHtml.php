<?php
/**
 * HTML layout for Abe Personal Finance
 *
 * Each script should create and use an object from this class when it's not
 * responding to an ajax request.
 * @author misterhaan
 */
class abeHtml {
	const SITE_NAME_FULL = 'Abe Personal Finance';
	const SITE_NAME_SHORT = 'Abe';

	/**
	 * Whether the HTML has been opened.
	 * @var bool
	 */
	private $isopen = false;
	/**
	 * Whether the HTML has been closed.
	 * @var bool
	 */
	private $isclosed = false;

	/**
	 * Action links to put in the header.
	 * @var array
	 */
	private $actions = [];

	/**
	 * Creates a new abeHtml object.
	 */
	public function abeHtml() {
		$this->back = INSTALL_PATH . '/';
	}

	/**
	 * Add an action link to the header.  Must be called before Open().
	 * @param string $url Action link URL.
	 * @param string $class CSS class name for the action (used to replace text with a fontawesome icon)
	 * @param string $text Link text (usually hidden by the class).
	 * @param string $tooltip Link tooltip text.
	 */
	public function AddAction($url, $class, $text, $tooltip = '') {
		$this->actions[] = ['url' => $url, 'class' => $class, 'text' => $text, 'tooltip' => $tooltip];
	}

	/**
	 * Starts the HTML and writes out the header.  This should be called before
	 * any other HTML output from the script.
	 * @param string $title Title of the page to display on the browser tab.  The site name will be added to the end if it's not contained in the title.
	 */
	public function Open($title) {
		if($this->isopen)
			return;
		$this->isopen = true;
		if(strpos($title, self::SITE_NAME_FULL) === false && strpos($title, self::SITE_NAME_SHORT) === false)
			$title .= ' - ' . self::SITE_NAME_SHORT;
		header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang=en>
	<head>
		<meta charset=utf-8>
		<meta name=viewport content="width=device-width, initial-scale=1">
		<title><?php echo $title; ?></title>
		<link rel=stylesheet href="<?php echo INSTALL_PATH; ?>/theme/abe.css">
		<script src="<?php echo INSTALL_PATH; ?>/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="<?php echo INSTALL_PATH; ?>/knockout-3.4.2.js" type="text/javascript"></script>
<?php
		if(basename($_SERVER['SCRIPT_NAME']) == 'spending.php') {
?>
		<script src="<?php echo INSTALL_PATH; ?>/d3.min.js" type="text/javascript"></script>
<?php
		}
?>
		<script src="<?php echo INSTALL_PATH; ?>/abe.js" type="text/javascript"></script>
<?php
		if(file_exists(str_replace('.php', '.js', $_SERVER['SCRIPT_FILENAME']))) {
?>
		<script src="<?php echo str_replace('.php', '.js', $_SERVER['SCRIPT_NAME']); ?>" type="text/javascript"></script>
<?php
		}
?>
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo INSTALL_PATH; ?>/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo INSTALL_PATH; ?>/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo INSTALL_PATH; ?>/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo INSTALL_PATH; ?>/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo INSTALL_PATH; ?>/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo INSTALL_PATH; ?>/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo INSTALL_PATH; ?>/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo INSTALL_PATH; ?>/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo INSTALL_PATH; ?>/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo INSTALL_PATH; ?>/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo INSTALL_PATH; ?>/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo INSTALL_PATH; ?>/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo INSTALL_PATH; ?>/favicon-16x16.png">
		<meta name="msapplication-TileColor" content="#593">
		<meta name="msapplication-TileImage" content="<?php echo INSTALL_PATH; ?>/ms-icon-144x144.png">
		<meta name="theme-color" content="#593">
	</head>
	<body>
		<header>
			<span class=back>
<?php
		if($_SERVER['PHP_SELF'] != INSTALL_PATH . '/index.php') {
?>
				<a href="<?php echo INSTALL_PATH; ?>/" title="Go to main menu"><span>home</span></a>
<?php
		}
?>
			</span>
			<span class=actions>
<?php
		foreach($this->actions as $action) {
?>
				<a class=<?php echo $action['class']; ?> href="<?php echo $action['url']; ?>" title="<?php echo $action['tooltip']; ?>"><span><?php echo $action['text']; ?></span></a>
<?php
		}
?>
			</span>
		</header>
		<main role=main>
<?php
	}

	/**
	 * Ends the HTML and writes out the footer.  This should be called after all
	 * other HTML output from the script.
	 */
	public function Close() {
		if(!$this->isopen || $this->isclosed)
			return;
		$this->isclosed = true;
?>
		</main>
		<footer>
			<div id=copyright>© 2017 <?php echo self::SITE_NAME_FULL; ?></div>
		</footer>
	</body>
</html>
<?php
	}
}
?>