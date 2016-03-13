<?php
//
// کـاربــر تـالار گفتگـوی پـرشـیـن اسکـریـپــت » i PersianScript « فـارسـی و زیـبـــا ! سـازی شـده تـوسـط 
//
// Copyright © 2011 All right reserved By » i PersianScript « the user » forum.persianscript.ir « Forum . 
//
// Powered by FTPLess .
//

include('config.php');

if (is_logged_in()) setcookie(md5($secret.'FTPLess'), '', time() - (60 * 60 * 7));

header('Location: index.php');
?>