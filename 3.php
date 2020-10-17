<?php
function wordUniqeu($input){
  $jumlah=strlen($input);
  $word= [];
  for($i=0;$i<$jumlah;$i++){
    $word[$i]=$input[$i];
  }
  $newWord = [];
  foreach ($word as $key => $value){
    if(!in_array($value, $newWord))
      $newWord[$key]=$value;
  }
  return inplode(',','$newWord');
}