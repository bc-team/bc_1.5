<?php
$files = glob(  "contents/system/entities". '/*.php' );
foreach ( $files as $file )
	require_once( $file );