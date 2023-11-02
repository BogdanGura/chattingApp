<?php

function sanitize($data)
{
   $data = trim($data);
   return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

?>