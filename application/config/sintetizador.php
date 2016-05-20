<?php

return array(
	'driver' => 'espeak',

	// Parametros especificos do Espeak
	'espeak' => array(
		'classe'          => 'Sintetizador_Espeak',
		'path_espeak'     => '/usr/bin/espeak',
		'path_lame'       => '/usr/bin/lame',
		'amplitude'       => null,
		'word_gap'        => null,
		'capital_letters' => null,
		'line_length'     => null,
		'pitch'           => null,
		'speed'           => null,
		'voice'           => 'pt',
		'sentence_pause'  => null,
		'punctuation'     => null,
	),

	// Parametros especificos do Ispeech
	'ispeech' => array(
		'classe'       => 'Sintetizador_Ispeech',
		'apikey'       => 'developerdemokeydeveloperdemokey',
		'voice'        => 'brportuguesefemale',
		'frequency'    => null,
		'bitrate'      => null,
		'speed'        => null,
		'startpadding' => null,
		'endpadding'   => null,
		'pitch'        => null,
		'bitdepth'     => null,
	),

	// Parametros especificos do Acapela
	'acapela' => array(
		'classe'    => 'Sintetizador_Acapela',
		'cl_app'    => 'EVAL_2612207',
		'cl_login'  => 'EVAL_VAAS',
		'cl_pwd'    => 'tshsgsso',
		'req_voice' => 'marcia22k',
	),
);
