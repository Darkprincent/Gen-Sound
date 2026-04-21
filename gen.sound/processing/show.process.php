
<?php
require_once "../models/model.php";
$track = selTrackFull(addBD(), $_GET['id']);
$link = getTrackLink(addBD(), $_GET['id']);
include "../views/show.view.php";