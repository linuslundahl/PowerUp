<?php
  // Composer
  require 'vendor/autoload.php';

  // Mustache
  $path = dirname(__FILE__) . '/templates/';
  $m = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader($path),
  ));

  // Variables
  include('includes/variables.php');

  // Functions
  include('includes/functions.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Power Up</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="assets/stylesheets/screen.css" rel="stylesheet" type="text/css" media="screen, projection" />
</head>
<body>

<div class="wrapper">
<?php echo get_template(arg(1)); // Print template ?>
</div>

<script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="assets/javascripts/plugins.js"></script>
<script src="assets/javascripts/scripts.js"></script>

</body>
</html>
