<?php declare(strict_types=1);

// @todo Figure out why scanning the `api` directory for this disocvery casues
//   a fatal error when `require_once 'api/Exception.php';`.
// $groupOptions = civicrm_api4('Group', 'getFields', ['loadOptions' => TRUE, 'select' => ['options', 'name'], 'where' => [['name', 'IN', ['visibility', 'group_type']]]]);

$civi = Civi::container();
$config = CRM_Core_Config::singleton();
