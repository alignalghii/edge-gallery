<?php

namespace app;

class Config
{
	const DB_HOST = '{{{DB_HOST}}}';
	const DB_NAME = '{{{DB_NAME}}}';
	const DB_USER = '{{{DB_USER}}}';
	const DB_PWD  = '{{{DB_PWD}}}';

	const BACKENDAPP_URL             =  '{{{BACKENDAPP_URL}}}';
	public static $BACKENDAPP_PARAMS = array(
		'{{{BACKENDAPP_PARAMNAME_PROP}}}' => '{{{BACKENDAPP_PLACEHOLDER_PROP}}}',
		'{{{BACKENDAPP_PARAMNAME_PIC}}}'  => '{{{BACKENDAPP_PLACEHOLDER_PIC}}}'
	);

	const DEBUG   = false;
	//const ROOT_APP = 'app'; // circular load in autoload.php
}
