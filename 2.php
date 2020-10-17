<?php
function reversAray($array){
  $jumah = count($array);
  $reversArray = [];
  $r=0;
  for($i=$jumah;$i>0;$i--){
    $reversArray[$r]=$array[$i-1];
    $r++;
  }
  return($reversArray);
}