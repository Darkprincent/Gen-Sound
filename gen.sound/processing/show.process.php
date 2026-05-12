<?php
require_once "../models/model.php";

$track = selTrackId(addBD(),  $_GET['id']);

include "../views/show.view.php";
