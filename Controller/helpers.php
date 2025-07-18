<?php
function site_url(string $url = '')
{
    return '//' . $_SERVER['HTTP_HOST'] . '/eom2/' . $url;
}