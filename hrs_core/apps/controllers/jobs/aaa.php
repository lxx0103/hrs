<?php
   $a = file_get_contents('http://www.hrs.com/jobs/calculate');
   echo $a;
   file_put_contents('a.txt', $a);
?>