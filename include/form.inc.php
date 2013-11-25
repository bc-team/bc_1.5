<?php
$files=glob("include/control/form". '/*.php');
foreach ( $files as $file )
	require_once( $file );