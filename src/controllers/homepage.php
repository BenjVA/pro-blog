<?php

require_once('src/model.php');

function homepage()
{
    $recentPosts = getRecentPosts();

    require('template/homepage.php');
}


