<?php 

//-------------------------------------------------

class Utils {
  public static function formatDate($str) {
    $date = new DateTime($str);
    return $date->format('d M Y');
  }

  public static function formatDateWithFormat($str, $format) {
    $date = new DateTime("$str");
    return $date->format($format);
  }
}


?> 
