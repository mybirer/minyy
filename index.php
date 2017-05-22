<?php
define('_MYINC','minyy'); //güvenlik ve direk dosya erişimini engellemek için gereklidir

require_once('config.php');
require_once('connection.php');

require_once('helpers/auth_helper.php');
require_once('helpers/view_helper.php');
require_once('helpers/functions_helper.php');
require_once('helpers/translate_helper.php');
require_once('helpers/message_helper.php');
require_once('helpers/module_helper.php');

require_once('models/model_template.php');
require_once('models/users_model.php');
require_once('models/user_groups_model.php');
require_once('models/view_levels_model.php');

require_once('models/posts_model.php');
require_once('models/teams_model.php');
require_once('models/team_members_model.php');
require_once('models/medias_model.php');
require_once('models/topics_model.php');
require_once('models/subtitles_model.php');
require_once('models/languages_model.php');
require_once('models/comments_model.php');

require_once('routes.php');
