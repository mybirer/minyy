<?php
define('_MYINC','minyy'); //güvenlik ve direk dosya erişimini engellemek için gereklidir

require_once('config.php');
require_once('connection.php');

require_once('helpers/auth_helper.php');
require_once('helpers/view_helper.php');
require_once('helpers/functions_helper.php');
require_once('helpers/translate_helper.php');
require_once('helpers/message_helper.php');

require_once('models/model_template.php');
require_once('models/users_model.php');

require_once('routes.php');
