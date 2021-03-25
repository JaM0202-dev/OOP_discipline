<?php
$methods = [
	'submitAmbassador' => [
		'params' => [
			[
				'name' => 'firstname',
				'source' => 'p',
				'pattern' => 'Name',
				'required' => true
			],
			[
				'name' => 'secondname',
				'source' => 'p',
				'pattern' => 'Name',
				'required' => true
			],
			[
				'name' => 'position',
				'source' => 'p',
				'pattern' => '',
				'required' => false
			],
			[
				'name' => 'phone',
				'source' => 'p',
				'pattern' => '',
				'required' => true
			],
			[
				'name' => 'email',
				'source' => 'p',
				'pattern' => 'Email',
				'required' => true
			]
		]
	]
];