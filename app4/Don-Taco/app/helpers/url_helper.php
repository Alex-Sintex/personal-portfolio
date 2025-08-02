<?php
// To redirect page
function redirection($page) {
    header('location: ' . PATH_URL . $page);
}