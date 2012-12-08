<?php
/**
 * MediaWiki Flickr Extension
 * {{php}}{{Category:Extensions|Flickr}}
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Yount aka icarusfactor factorf2@yahoo.com
 * @licence GNU General Public Licence 3.0 or later
 */
 
define('FLICKR_VERSION','0.3');
 
$wgExtensionFunctions[] = 'SetupFlickr';
$wgHooks['LanguageGetMagic'][] = 'FlickrLanguageGetMagic';

$wgExtensionCredits['parserhook'][] = array(
        'name'        => 'Flickr Image',
        'author'      => 'Daniel Yount - icarusfactor',
        'description' => 'Flickr Image Embed Extension',
        'url'         => 'http://www.mediawiki.org',
        'version'     => FLICKR_VERSION
);
 
function FlickrLanguageGetMagic(&$magicWords,$langCode = 0) {
        $magicWords['flickr'] = array(0,'flickr');
        return true;
}
 
function SetupFlickr()
      {
        global $wgParser;
        $wgParser->setFunctionHook('flickr','RenderFlickr');
        return true;
      }
 
# Renders a table of all the individual month tables
function RenderFlickr( &$parser) 
      {
        global $wgScriptPath;
        $output= '';

        #$parser->mOutput->mCacheTime = -1;
       $argv = array();
     foreach (func_get_args() as $arg) if (!is_object($arg)) {
               if (preg_match('/^(.+?)\\s*=\\s*(.+)$/',$arg,$match)) $argv[$match[1]]=$match[2];
      }
       if (isset($argv['farmid']))  { $farmid = $argv['farmid'];  } else { return $output; }
       if (isset($argv['imageid'])) { $imageid  = $argv['imageid']; } else { return $output; }
       if (isset($argv['width']))     $sizew  = $argv['width'];  else $sizew  = '300';
       if (isset($argv['height']))    $sizeh  = $argv['height']; else $sizeh = '300';

      #example data
      #$farmid = "farm8";
      #$imageid = "7137/7482373374_760efa23cf";
      #$sizew =    "300";
      #$sizeh =    "300";

        $farmid = str_replace( ' ' , '%20' , urlencode( $farmid ) );
       $imageid = str_replace( ' ' , '%20' , urlencode( $imageid ) );

        $output .= '<img src="http://'.$farmid.'.staticflickr.com/'.$imageid.'.jpg" width="'.$sizew.'" height="'.$sizeh.'" >';
 

       return $parser->insertStripItem( $output, $parser->mStripState );
#    return $output;

      }

?>
