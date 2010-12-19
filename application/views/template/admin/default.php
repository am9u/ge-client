<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="utf-8" />
		<title><?php echo empty($page_title) ? '' : "$page_title - "; ?><?php echo empty($site_title) ? '' : $site_title; ?></title>

		<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)) . "\n"; ?>
		<?php foreach ($scripts as $file) echo HTML::script($file) . "\n"; ?>

	</head>

<body>
<div id="container" class="page<?php echo empty($page_title) ? '' : " page-".str_replace('/', '-', Request::instance()->uri()); ?>">
    <div id="header">
        <?php echo empty($site_title) ? '' : '<h1>'.$site_title.'</h1>'; ?>
        <h2>Admin: <?php echo $page_title; ?></h2>
    </div>

    <?php echo View::factory('template/admin/include/nav'); ?>

    <div id="main">
        <?php echo empty($content) ? '' : $content; ?>
    </div>

    <div id="footer">
        <p>A Client Web Application for the API</p>
    </div>
    
</div>
</body>

</html>

