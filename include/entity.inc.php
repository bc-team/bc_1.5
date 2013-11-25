<?php 
$files = glob("include/model/". '/*.php' );
foreach ( $files as $file )
	require_once( $file );