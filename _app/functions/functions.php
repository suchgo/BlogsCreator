<?php

/* Фунция экранирования всех данных */
function safety($str) {
  $str = htmlspecialchars(strip_tags($str),ENT_QUOTES);
  return $str;
}