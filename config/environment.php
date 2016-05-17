<?php
return [

    'sso_url' => env('SSO_URL'),
    'sso_get_xml_url' => env('SSO_GET_XML_URL'),

    'mailEnable' => env('ENABLE_NOTIFY', false),
    'primaryReceiver' => env('MAIL_NOTIFY_PRIMARY'),
    'secondaryReceiver' => env('MAIL_NOTIFY_SECONDARY'),
    'testReceiver' => env('MAIL_NOTIFY_TEST'),
    'studentManualLogin' => env('STU_MAN_LOGIN', true)

];