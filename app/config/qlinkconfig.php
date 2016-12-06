<?php                                                                                                                                                                 

return array(
    'local' => array(
        'site_url' => 'http://qlink',
        'secure_site' => false,
	'enabled_anti_fire' => false,
        'expire_seconds' => 86400, //24horas
    	'allowed_servers' => array(
		"one",
		"two"
	),
    	'current_storage' => 'two',
	'qlink_corporate_site_url' => 'http://qlink/main'	
    ),
    'production' => array(
        'site_url' => 'http://qlink',
        'secure_site' => false,
	'enabled_anti_fire' => true,
        'expire_seconds' => 86400, //24horas
    	'allowed_servers' => array(
                "one",
		"two"
        ),
	'current_storage' => 'one',
    	'qlink_corporate_site_url' => 'http://qlink/main'
    )
);
