<?php 
function printImage($size){
  $satuan ="px";
  $size = $size.$satuan;
  echo "<img src=\"image,jpg\" width=\"$size\" height=\"$size\"\/>";
}