<?php declare(strict_types=1);

$groupOptions = civicrm_api4('Group', 'getFields', ['loadOptions' => TRUE, 'select' => ['options', 'name'], 'where' => [['name', 'IN', ['visibility', 'group_type']]]]);

$config = CRM_Core_Config::singleton();
