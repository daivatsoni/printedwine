<?php
//This function prints a text array as an html list.
function alist ($array) {  
  $alist = "<ul>";
  for ($i = 0; $i < sizeof($array); $i++) {
    $alist .= "<li>$array[$i]";
  }
  $alist .= "</ul>";
  return $alist;
}
//Try to get ImageMagick "convert" program version number.
exec("convert -version", $out, $rcode);
//Print the return code: 0 if OK, nonzero if error. 
echo "Version return code is $rcode <br>"; 
//Print the output of "convert -version"    
//echo alist($out); 

//exec("convert bottle3.png label1.png -compose Mathematics -define compose:args='1,0,0,0' -composite result.png");

exec("composite -compose ATop -geometry -13-17 bottle3.png label1.png result.png");

if(!extension_loaded('imagick'))
    echo 'imagick not installed';
?>