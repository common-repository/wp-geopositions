<?php
require('wp-blog-header.php');

if (isset($_GET['type']) && isset($_GET['id'])) {
  ioz_gp_get_position_file($_GET['id'], $_GET['type']);
}
?>