<?php

namespace App\controllers\homepage;

use App\model\Article;

$recentArticles = getRecentArticles();

require('template/homepage.php');
