<?php
/*

  MD5 Checksum File Parser
  ========================

  Copyright (c) 2004 Kirill Zinov

  This library is free software; you can redistribute it and/or modify it under the terms of
  the GNU Lesser General Public License as published by the Free Software Foundation;
  either version 2.1 of the License, or (at your option) any later version.

  This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
  See the GNU Lesser General Public License for more details.

  You should have received a copy of the GNU Lesser General Public License along with this
  library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330,
  Boston, MA 02111-1307 USA.

  If you have any questions or comments, please email:
  Kirill Zinov support@fastsum.com
  FastSum project http://www.fastsum.com

*/

// Do not warn about Windows does not support dates prior to midnight (00:00:00), January 1, 1970
//error_reporting (E_ERROR | E_PARSE);


$maxMD5Line = 4096;
$remarkID = array(";", "#");
$extraInfoID = '$PE:';
$rootID = '$PR:';

$EXTRA_DATE_ID = 01;
$EXTRA_TIME_ID = 02;
$EXTRA_USER_ID = 03;
$EXTRA_HOST_ID = 04;
$EXTRA_ROOT_ID = 05;

class MD5Parser{

	var $FileName;
    var $Result;

    function MD5Parser($file)
    {
     	$this->FileName = $file;

        // Initialize array with the default values
        $this->Result = array("Count" => 0,
                              "DateTime" => 0,
                              "User" => "", "Host" => "", "Root" => "",
                              "Values" => array());
    }
	
    function GetString($Str) {
    	$s = "";
        for ($j = 0; $j < strlen($Str); $j = $j + 2) {
        	$s = $s . chr(hexdec(substr($Str, $j, 2)));
        }
        return utf8_decode($s);
    }	
	
    function GetLongString($Str) {
    	$s = "";
        for ($j = 0; $j < strlen($Str); $j = $j + 2) {
        	$s = $s . chr(hexdec(substr($Str, $j, 2)));
        }
        return utf8_decode($s);
    }	

    function ParseExtra($Info) {
        global $EXTRA_DATE_ID, $EXTRA_TIME_ID, $EXTRA_USER_ID, $EXTRA_HOST_ID;

        $i = 0;
        while ($i < strlen($Info)) {
            $ID = hexdec(substr($Info, $i, 2));
            $Size = hexdec(substr($Info, $i + 2, 2));
            $i = $i + 4;
            switch ($ID) {
                case $EXTRA_DATE_ID:
                  $d1 = hexdec(substr($Info, $i, 2));
                  $d2 = hexdec(substr($Info, $i + 2, 2));
                  $d3 = hexdec(substr($Info, $i + 4, 4));
                  $this->Result['DateTime'] = mktime(0, 0, 0, $d2, $d1, $d3);
                  break;
                case $EXTRA_TIME_ID:
                  $t1 = hexdec(substr($Info, $i, 2));
                  $t2 = hexdec(substr($Info, $i + 2, 2));
                  $t3 = hexdec(substr($Info, $i + 4, 2));
                  $this->Result['DateTime'] = mktime($t1, $t2, $t3, $d1, $d2, $d3);
                  break;
                case $EXTRA_USER_ID:
                  $this->Result['User'] = $this->GetString(substr($Info, $i, $Size));
                  break;
                case $EXTRA_HOST_ID:
                  $this->Result['Host'] = $this->GetString(substr($Info, $i, $Size));
                  break;
            }
            $i = $i + $Size;
        }
    }

    function GetRoot($Info) {
        $Size = hexdec(substr($Info, 2, 4));
        return $this->GetLongString(substr($Info, 6, $Size));
    }

    function Parse()
    {
     	global $maxMD5Line, $remarkID, $extraInfoID, $rootID;

        $extraFound = False;
        $rootFound = False;
     	$handle = fopen($this->FileName, "r") or die('Can not to open file ' . $this->FileName);
        while (!feof ($handle)) {
            $line = trim(fgets($handle, $maxMD5Line));
            if ($line) {
                if (in_array($line[0], $remarkID)) {
                    if (!$extraFound) {
                         $a = explode($extraInfoID, $line);
                         if (Count($a) > 1) {
                             $extraFound = $this->ParseExtra(trim($a[1]));
                         }
                    }
                    if (!$rootFound) {
                         $a = explode($rootID, $line);
                         if (Count($a) > 1) {
                             $this->Result['Root'] = $this->GetRoot(trim($a[1]));
                         }
                    }
                } else {
                    if (strlen($line) > 34) {
                        $a = explode('*', $line);
                        $hash = strtoupper(trim($a[0]));
                        $file = trim($a[1]);
                        $this->Result['Values'][$file] = $hash;
                    } else {
                        return False;
                    }
                }
            }
        }
        fclose($handle);
    }
}

?>