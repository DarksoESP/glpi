<?php
/*
 * @version $Id$
 ----------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2006 by the INDEPNET Development Team.
 
 http://indepnet.net/   http://glpi.indepnet.org
 ----------------------------------------------------------------------

 LICENSE

	This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ------------------------------------------------------------------------
*/

// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------







//******************************************************************************************************
//******************************************************************************************************
//********************************  Fonctions de   ????? ************************************
//******************************************************************************************************
//******************************************************************************************************




function getDeviceTypeName($ID){
global $lang;
switch ($ID){
	case COMPUTER_TYPE : return $lang["help"][25];break;
	case NETWORKING_TYPE : return $lang["help"][26];break;
	case PRINTER_TYPE : return $lang["help"][27];break;
	case MONITOR_TYPE : return $lang["help"][28];break;
	case PERIPHERAL_TYPE : return $lang["help"][29];break;
	case SOFTWARE_TYPE : return $lang["help"][31];break;
	case CARTRIDGE_TYPE : return $lang["Menu"][21];break;
	case CONTACT_TYPE : return $lang["Menu"][22];break;
	case ENTERPRISE_TYPE : return $lang["Menu"][23];break;
	case CONTRACT_TYPE : return $lang["Menu"][25];break;
	case CONSUMABLE_TYPE : return $lang["Menu"][32];break;


}

}

/**
* To be commented
*
*
*
* @param $s
* @return 
*
*/
function stripslashes_deep($value) {
       $value = is_array($value) ?
                   array_map('stripslashes_deep', $value) :
                   (is_null($value) ? NULL : stripslashes($value));
                   
       return $value;
}

/**
* To be commented
*
*
*
* @param $value
* @return 
*
*/
function addslashes_deep($value) {
       $value = is_array($value) ?
                   array_map('addslashes_deep', $value) :
                   (is_null($value) ? NULL : addslashes($value));
       return $value;
}


function clean_cross_side_scripting_deep($value) {
	$in=array("<",">");
	$out=array("&lt;","&gt;");
       $value = is_array($value) ?
                   array_map('clean_cross_side_scripting_deep', $value) :
                   (is_null($value) ? NULL : str_replace($in,$out,$value));
       return $value;
}

function unclean_cross_side_scripting_deep($value) {
	$in=array("<",">");
	$out=array("&lt;","&gt;");
       $value = is_array($value) ?
                   array_map('clean_cross_side_scripting_deep', $value) :
                   (is_null($value) ? NULL : str_replace($out,$in,$value));
       return $value;
}

function utf8_decode_deep($value) {
	$value = is_array($value) ?
		array_map('utf8_decode_deep', $value) :
			(is_null($value) ? NULL : utf8_decode($value));
	return $value;
	
}


//****************
// De jolies fonctions pour am�liorer l'affichage du texte de la FAQ/knowledgbase
//***************

/**
*Met en "ordre" une chaine avant affichage
* Remplace tr�s AVANTAGEUSEMENT nl2br 
* 
* @param $pee
* 
* 
* @return $string
*/
function autop($pee, $br=1) {

// Thanks  to Matthew Mullenweg

$pee = preg_replace("/(\r\n|\n|\r)/", "\n", $pee); // cross-platform newlines
$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
$pee = preg_replace('/\n?(.+?)(\n\n|\z)/s', "<p>$1</p>\n", $pee); // make paragraphs, including one at the end
if ($br) $pee = preg_replace('|(?<!</p>)\s*\n|', "<br>\n", $pee); // optionally make line breaks
return $pee;
}


/**
* Rend une url cliquable htp/https/ftp meme avec une variable Get
*
* @param $chaine
* 
* 
* 
* @return $string
*/
function clicurl($chaine){

$text=preg_replace("`((?:https?|ftp)://\S+)(\s|\z)`", '<a href="$1">$1</a>$2', $chaine); 

return $text;
}

/**
* Split the message into tokens ($inside contains all text inside $start and $end, and $outside contains all text outside)
*
* @param $text
* @param $start
* @param $end
* 
* @return array 
*/
function split_text($text, $start, $end)
{
	
// Adapt� de PunBB 
//Copyright (C)  Rickard Andersson (rickard@punbb.org)

	$tokens = explode($start, $text);

	$outside[] = $tokens[0];

	$num_tokens = count($tokens);
	for ($i = 1; $i < $num_tokens; ++$i)
	{
		$temp = explode($end, $tokens[$i]);
		$inside[] = $temp[0];
		$outside[] = $temp[1];
	}

	

	return array($inside, $outside);
}


/**
* Replace bbcode in text by html tag
*
* @param $string
* 
* 
* 
* @return $string 
*/
function rembo($string){

// Adapt� de PunBB 
//Copyright (C)  Rickard Andersson (rickard@punbb.org)

// If the message contains a code tag we have to split it up (text within [code][/code] shouldn't be touched)
	if (strpos($string, '[code]') !== false && strpos($string, '[/code]') !== false)
	{
		list($inside, $outside) = split_text($string, '[code]', '[/code]');
		$outside = array_map('trim', $outside);
		$string = implode('<">', $outside);
	}




	$pattern = array('#\[b\](.*?)\[/b\]#s',
					 '#\[i\](.*?)\[/i\]#s',
					 '#\[u\](.*?)\[/u\]#s',
					  '#\[s\](.*?)\[/s\]#s',
					  '#\[c\](.*?)\[/c\]#s',
					 '#\[g\](.*?)\[/g\]#s',
					 //'#\[url\](.*?)\[/url\]#e',
					 //'#\[url=(.*?)\](.*?)\[/url\]#e',
					 '#\[email\](.*?)\[/email\]#',
					 '#\[email=(.*?)\](.*?)\[/email\]#',
					 '#\[color=([a-zA-Z]*|\#?[0-9a-fA-F]{6})](.*?)\[/color\]#s');

					 
	$replace = array('<strong>$1</strong>',
					 '<em>$1</em>',
					 '<span class="souligne">$1</span>',
					'<span class="barre">$1</span>',
					'<div align="center">$1</div>',
					'<big>$1</big>',
					// 'truncate_url(\'$1\')',
					 //'truncate_url(\'$1\', \'$2\')',
					 '<a href="mailto:$1">$1</a>',
					 '<a href="mailto:$1">$2</a>',
					 '<span style="color: $1">$2</span>');

	// This thing takes a while! :)
	$string = preg_replace($pattern, $replace, $string);

	
	
	$string=clicurl($string);
	
	$string=autop($string);
	
	
	// If we split up the message before we have to concatenate it together again (code tags)
	if (isset($inside))
	{
		$outside = explode('<">', $string);
		$string = '';

		$num_tokens = count($outside);

		for ($i = 0; $i < $num_tokens; ++$i)
		{
			$string .= $outside[$i];
			if (isset($inside[$i]))
				$string .= '<br><br><table  class="code" align="center" cellspacing="4" cellpadding="6"><tr><td class="punquote"><b>Code:</b><br><br><pre>'.trim($inside[$i]).'</pre></td></tr></table><br>';
		}
	}

	
	
	
	
	
	return $string;
}






function convDateTime($time) { 
 global $cfg_layout;
 if (is_null($time)) return $time;
 if ($cfg_layout["dateformat"]!=0) {
   $date = substr($time,8,2)."-";        // jour 
   $date = $date.substr($time,5,2)."-";  // mois 
   $date = $date.substr($time,0,4). " "; // année 
   $date = $date.substr($time,11,5);     // heures et minutes 
   return $date; 
 }else {
 return $time;
 }
 }
 function convDate($time) { 
 global $cfg_layout;
 if (is_null($time)) return $time;
 if ($cfg_layout["dateformat"]!=0) {
   $date = substr($time,8,2)."-";        // jour 
   $date = $date.substr($time,5,2)."-";  // mois 
   $date = $date.substr($time,0,4). " "; // année 
   //$date = $date.substr($time,11,5);     // heures et minutes 
   return $date; 
 }else {
 return $time;
 }
 }
/**
* To be commented
*
* @param $file
* @param $filename
* @return nothing
*/
function sendFile($file,$filename){

        // Test s�curit�
	if (ereg("\.\.",$file)){
	session_start();
	echo "Security attack !!!";
	logEvent($file, "sendFile", 1, "security", $_SESSION["glpiname"]." try to get a non standard file.");
	return;
	}
	if (!file_exists($file)){
	echo "Error file $file does not exist";
	return;
	} else {
		$db = new DB;
		$splitter=split("/",$file);
		$filedb=$splitter[count($splitter)-2]."/".$splitter[count($splitter)-1];
		$query="SELECT mime from glpi_docs WHERE filename LIKE '$filedb'";
		$result=$db->query($query);
		$mime="application/octetstream";
		if ($result&&$db->numrows($result)==1){
			$mime=$db->result($result,0,0);
			
		} else {
			// fichiers DUMP SQL et XML
			if ($splitter[count($splitter)-2]=="dump"){
				$splitter2=split("\.",$file);
				switch ($splitter2[count($splitter2)-1]) {
					case "sql" : 
						$mime="text/x-sql";
						break;
					case "xml" :
						$mime="text/xml";
						break;
				}
			} else {
				// Cas particulier
				switch ($splitter[count($splitter)-2]) {
					case "SQL" : 
						$mime="text/x-sql";
						break;
					case "XML" :
						$mime="text/xml";
						break;
				}
			}
			
		}
		
		header("Content-disposition: filename=\"$filename\"");
		
     	header("Content-type: ".$mime);
		 // Condition for IE bug
		 if (!ereg("https://",$_SERVER["SCRIPT_URI"]))
	     	header('Pragma: no-cache');
     	header('Expires: 0');
		$f=fopen($file,"r");
		
		if (!$f){
		echo "Error opening file $file";
		} else {
			// Pour que les \x00 ne devienne pas \0
			$mc=get_magic_quotes_runtime();
			if ($mc) @set_magic_quotes_runtime(0); 
			
			echo fread($f, filesize($file));

			if ($mc) @set_magic_quotes_runtime($mc); 
		}
	
	}
}


function return_bytes_from_ini_vars($val) {
   $val = trim($val);
   $last = strtolower($val{strlen($val)-1});
   switch($last) {
       // Le modifieur 'G' est disponible depuis PHP 5.1.0
       case 'g':
           $val *= 1024;
       case 'm':
           $val *= 1024;
       case 'k':
           $val *= 1024;
   }

   return $val;
}

function glpi_header($dest){
echo "<script language=javascript>window.location=\"".$dest."\"</script>";
exit();
}

function getMultiSearchItemForLink($name,$array){
	
	$out="";
	if (is_array($array)&&count($array)>0)
	foreach($array as $key => $val){
		if ($name!="link"||$key!=0)
			$out.="&amp;".$name."[$key]=".$array[$key];
	}
	return $out;
	
}


function get_hour_from_sql($time){
$t=explode(" ",$time);
$p=explode(":",$t[1]);
return $p[0].":".$p[1];
}

function optimize_tables (){
	
$db = new DB;
$result=$db->list_tables();
	while ($line = $db->fetch_array($result))
   	{
   		if (ereg("glpi_",$line[0])){
			$table = $line[0];
   		$query = "OPTIMIZE TABLE ".$table." ;";
   		$db->query($query);
		}
  	 }
mysql_free_result($result);
}


?>
