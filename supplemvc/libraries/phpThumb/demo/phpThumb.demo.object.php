<?php
//////////////////////////////////////////////////////////////
///  phpThumb() by James Heinrich <info@silisoftware.com>   //
//        available at http://phpthumb.sourceforge.net     ///
//////////////////////////////////////////////////////////////
///                                                         //
// phpThumb.demo.object.php                                 //
// James Heinrich <info@silisoftware.com>                   //
//                                                          //
// Example of how to use phpthumb.class.php as an object    //
//                                                          //
//////////////////////////////////////////////////////////////

// Note: phpThumb.php is where the caching code is located, if
//   you instantiate your own phpThumb() object that code is
//   bypassed and it's up to you to handle the reading and
//   writing of cached files, if appropriate.

//die('For security reasons, this demo is disabled by default. Please comment out line '.__LINE__.' in '.basename(__FILE__));

require_once('../phpthumb.class.php');

// create phpThumb object
$phpThumb = new phpThumb();

// create 3 sizes of thumbnail
$thumbnail_widths = array(160, 320, 640);
$capture_raw_data = false; // set to true to insert to database rather than render to screen or file (see below)

foreach ($thumbnail_widths as $thumbnail_width) {
	// this is very important when using a single object to process multiple images
	$phpThumb->resetObject();

	// set data source -- do this first, any settings must be made AFTER this call
	$phpThumb->setSourceFilename('/supplemvc/lib/phpThumb/images/loco.jpg');  // for static demo only
	//$phpThumb->setSourceFilename($_FILES['userfile']['tmp_name']);
	// or $phpThumb->setSourceData($binary_image_data);
	// or $phpThumb->setSourceImageResource($gd_image_resource);

	// PLEASE NOTE:
	// You must set any relevant config settings here. The phpThumb
	// object mode does NOT pull any settings from phpThumb.config.php
	$phpThumb->setParameter('config_document_root', $_SERVER['DOCUMENT_ROOT']); //'/home/groups/p/ph/phpthumb/htdocs/');
	$phpThumb->setParameter('config_cache_directory', '/home/sherto5/public_html/shertonquotes2-test/supplemvc/lib/phpThumb/cache'); //'/tmp/persistent/phpthumb/cache/');
	$phpThumb->setParameter('config_temp_directory', '/home/sherto5/public_html/shertonquotes2-test/supplemvc/lib/phpThumb/cache'); //'/tmp/persistent/phpthumb/cache/');

	$phpThumb->setParameter('config_cache_directory_depth', 4);
	$phpThumb->setParameter('config_cache_disable_warning', false);

	// set parameters (see "URL Parameters" in phpthumb.readme.txt)
	$phpThumb->setParameter('w', $thumbnail_width);
	//$phpThumb->setParameter('h', 100);
	//$phpThumb->setParameter('fltr', 'gam|1.2');
	//$phpThumb->setParameter('fltr', 'wmi|../watermark.jpg|C|75|20|20');

	// set options (see phpThumb.config.php)
	// here you must preface each option with "config_"
	$phpThumb->setParameter('config_output_format', 'jpg');
	$phpThumb->setParameter('config_imagemagick_path', null);
	$phpThumb->setParameter('config_allow_src_above_docroot', true); // needed if you're working outside DOCUMENT_ROOT, in a temp dir for example

	// generate & output thumbnail
	$output_filename = '/home/sherto5/public_html/shertonquotes2-test/supplemvc/lib/phpThumb/demo/thumbnails/img_' . $thumbnail_width . '.' . $phpThumb->config_output_format;

	if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!

		phpthumb_functions::EnsureDirectoryExists(dirname($phpThumb->cache_filename));
		if (is_writable(dirname($phpThumb->cache_filename)) || (file_exists($phpThumb->cache_filename) && is_writable($phpThumb->cache_filename))) {

			$phpThumb->CleanUpCacheDirectory();
			if ($phpThumb->RenderToFile($phpThumb->cache_filename) && is_readable($phpThumb->cache_filename)) {
				chmod($phpThumb->cache_filename, 0644);
				RedirectToCachedFile($phpThumb, $PHPTHUMB_CONFIG);
			} else {
				$phpThumb->DebugMessage('Failed: RenderToFile('.$phpThumb->cache_filename.')', __FILE__, __LINE__);
			}

		} else {

			$phpThumb->DebugMessage('Cannot write to $phpThumb->cache_filename ('.$phpThumb->cache_filename.') because that directory ('.dirname($phpThumb->cache_filename).') is not writable', __FILE__, __LINE__);

		}

//		$phpThumb->RenderToFile($output_filename);
//		$phpThumb->purgeTempFiles();
//		$phpThumb->OutputThumbnail();
		echo '<form><textarea rows="10" cols="60" wrap="off">'.htmlentities(implode("\n* ", $phpThumb->debugmessages)).'</textarea></form><hr>';

	} else {
		// do something with debug/error messages
		echo 'Failed (size='.$thumbnail_width.').<br>';
		echo '<div style="background-color:#FFEEDD; font-weight: bold; padding: 10px;">'.$phpThumb->fatalerror.'</div>';
		echo '<form><textarea rows="10" cols="60" wrap="off">'.htmlentities(implode("\n* ", $phpThumb->debugmessages)).'</textarea></form><hr>';
	}


}


function RedirectToCachedFile($phpThumb, $PHPTHUMB_CONFIG) {
//	global $phpThumb, $PHPTHUMB_CONFIG;

	$nice_cachefile = str_replace(DIRECTORY_SEPARATOR, '/', $phpThumb->cache_filename);
	$nice_docroot   = str_replace(DIRECTORY_SEPARATOR, '/', rtrim($PHPTHUMB_CONFIG['document_root'], '/\\'));

	$parsed_url = phpthumb_functions::ParseURLbetter(@$_SERVER['HTTP_REFERER']);

	$nModified  = filemtime($phpThumb->cache_filename);

	if ($phpThumb->config_nooffsitelink_enabled && @$_SERVER['HTTP_REFERER'] && !in_array(@$parsed_url['host'], $phpThumb->config_nooffsitelink_valid_domains)) {

		//$phpThumb->DebugMessage('Would have used cached (image/'.$phpThumb->thumbnailFormat.') file "'.$phpThumb->cache_filename.'" (Last-Modified: '.gmdate('D, d M Y H:i:s', $nModified).' GMT), but skipping because $_SERVER[HTTP_REFERER] ('.@$_SERVER['HTTP_REFERER'].') is not in $phpThumb->config_nooffsitelink_valid_domains ('.implode(';', $phpThumb->config_nooffsitelink_valid_domains).')', __FILE__, __LINE__);

	} elseif ($phpThumb->phpThumbDebug) {

		$phpThumb->DebugTimingMessage('skipped using cached image', __FILE__, __LINE__);
		$phpThumb->DebugMessage('Would have used cached file, but skipping due to phpThumbDebug', __FILE__, __LINE__);
		$phpThumb->DebugMessage('* Would have sent headers (1): Last-Modified: '.gmdate('D, d M Y H:i:s', $nModified).' GMT', __FILE__, __LINE__);
		if ($getimagesize = @GetImageSize($phpThumb->cache_filename)) {
			$phpThumb->DebugMessage('* Would have sent headers (2): Content-Type: '.phpthumb_functions::ImageTypeToMIMEtype($getimagesize[2]), __FILE__, __LINE__);
		}
		if (preg_match('#^'.preg_quote($nice_docroot).'(.*)$#', $nice_cachefile, $matches)) {
			$phpThumb->DebugMessage('* Would have sent headers (3): Location: '.dirname($matches[1]).'/'.urlencode(basename($matches[1])), __FILE__, __LINE__);
		} else {
			$phpThumb->DebugMessage('* Would have sent data: readfile('.$phpThumb->cache_filename.')', __FILE__, __LINE__);
		}

	} else {

		if (headers_sent()) {
			$phpThumb->ErrorImage('Headers already sent ('.basename(__FILE__).' line '.__LINE__.')');
			exit;
		}
		SendSaveAsFileHeaderIfNeeded($phpThumb, $PHPTHUMB_CONFIG);

		header('Last-Modified: '.gmdate('D, d M Y H:i:s', $nModified).' GMT');
		if (@$_SERVER['HTTP_IF_MODIFIED_SINCE'] && ($nModified == strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) && @$_SERVER['SERVER_PROTOCOL']) {
			header($_SERVER['SERVER_PROTOCOL'].' 304 Not Modified');
			exit;
		}

		if ($getimagesize = @GetImageSize($phpThumb->cache_filename)) {
			header('Content-Type: '.phpthumb_functions::ImageTypeToMIMEtype($getimagesize[2]));
		} elseif (preg_match('#\\.ico$#i', $phpThumb->cache_filename)) {
			header('Content-Type: image/x-icon');
		}
		if (!@$PHPTHUMB_CONFIG['cache_force_passthru'] && preg_match('#^'.preg_quote($nice_docroot).'(.*)$#', $nice_cachefile, $matches)) {
			header('Location: '.dirname($matches[1]).'/'.urlencode(basename($matches[1])));
		} else {
			@readfile($phpThumb->cache_filename);
		}
		exit;

	}
	return true;
}

?>