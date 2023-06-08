<?php

return [

	'moneyForPoint' => [
	    'name' => 'ipoint::moneyForPoint',
	    'value' => 0,
	    'type' => 'input',
	    'props' => [
	      'label' => 'ipoint::points.settings.moneyForPoint',
	      'type' => 'number',
	      'hint' => 'ipoint::points.settingHints.moneyForPoint',
	    ],
  	],

  	'roundPoints' => [
	    'value' => "0",
	    'name' => 'ipoint::roundPoints',
	    'type' => 'checkbox',
	    'props' => [
	      'label' => 'ipoint::points.settings.roundPoints',
	      'hint' => 'ipoint::points.settingHints.roundPoints',
	      'trueValue' => "1",
	      'falseValue' => "0",
	    ]
	 ],

];
