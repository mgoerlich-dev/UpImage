#!/usr/bin/env php
<?php
## Config Start

// The directory to save the temporary Screenshot
$tmp_dir = '/tmp/';

// Command to take the shot
$screen_cmd = 'scrot';

// Any options for $screen_cmd ?
$screen_params = '-q 50';

// Name of the temporaray Screenshot file
$screen_name = 'screen.png';

## Config End

$screen_file = $tmp_dir . $screen_name;

/**
 * up2gp - Function to Upload an Image to gullipics.com
 * 
 * 
 * @param string $image path to an valid ImageFile ( valid means mimetype is 'image/*' )
 * @return object an Object of StdClass filled with Data retuned by the gullipics API (http://www.gullipics.com/about/api)
 */
function up2gp( $image ) {
    if( !exif_imagetype( $image ) )
        return false;
    
    $curl = curl_init();
    curl_setopt( $curl, CURLOPT_URL, 'http://www.gullipics.com/api/image/format/json' );
    curl_setopt( $curl, CURLOPT_POST, true );
    curl_setopt( $curl, CURLOPT_POSTFIELDS, array( 'image' => "@" . $image ) );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
    $json_response = curl_exec( $curl );
    $answer = json_decode( $json_response );

    return $answer;
}

function uploadImage( $file ) {
    $upload = up2gp( $file );
    $out = '';

    if( $upload ) {
        if( isset( $upload->error->message ) ) {
            foreach( $upload->error->message as $type => $message ) {
            $out .= 'Error( ' . $type . ' ): ' . $message . PHP_EOL;
            }
        } else {
            $out .= 'Upload erfolgreich.' . PHP_EOL;
            $out .= 'Image Link:' . "\t" . $upload->imageUrl . PHP_EOL;
            $out .= 'Thumbnail Link:' . "\t" . $upload->thumbUrl . PHP_EOL;
            $out .= 'Delete Link:' . "\t" . $upload->delUrl . PHP_EOL;
        }
    } else {
        $out .= 'Fehler: ' . $argv[2] . ' ist keine gültige Bildatei.' . PHP_EOL;
    }
    
    return $out;
}


function getScreen( $filename ) {
    global $screen_cmd, $screen_params;
    $return = array();
    exec( $screen_cmd . ' ' . $screen_params . ' ' . $filename, $return[1], $return[0] );
    return $return;
}

if( isset( $argv[1], $argv[2] ) && $argv[1] === '-f' ) {
    $out = uploadImage( $argv[2] );
} else if( isset( $argv[1] ) && ( $argv[1] === '-t' || $argv[1] === '--take-shot' ) ) {
    $shot = getScreen( $screen_file );
    if( $shot[0] === 0 ) {
        $out = uploadImage( $tmp_dir . 'screen.png' );
    } else {
        $out = 'Fehler: ' . PHP_EOL;
        foreach( $shot[1] as $error_line ) {
            $out .= $error_line . PHP_EOL;
        }
    }
    unlink( $screen_file );
} else {
    $script_name = explode( '/', $argv[0] );
    $script_name = $script_name[count($script_name) -1];
    $out = 'Usage:' . PHP_EOL;
    $out .= $script_name . ' -f <image>' . PHP_EOL;
    $out .= 'or' . PHP_EOL;
    $out .= $script_name . ' -t | --take-shot' . PHP_EOL;
}

print $out;
?>