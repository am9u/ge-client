<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="utf-8" />
		<title><?php echo empty($page_title) ? '' : "$page_title - "; ?><?php echo empty($site_title) ? '' : $site_title; ?></title>

		<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)) . "\n"; ?>
		<?php foreach ($scripts as $file) echo HTML::script($file) . "\n"; ?>

	</head>

<body>
	<?php echo empty($content) ? '' : $content; ?>
</body>

</html>

