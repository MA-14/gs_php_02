<?php
function h($s){
  return htmlspecialchars($s,ENT_QUOTES);
}


//勝敗予想をパーセンテージで出す
function rate($a,$b,$c){
  return round($a/($a+$b+$c)*100);
}