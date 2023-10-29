<?php

function sanitize($data)
{
   return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

?>