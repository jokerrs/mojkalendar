<?php
function route_array_preg(string $uri, array $array) {
    foreach (array_keys($array) as $arr) {
        $is_match = preg_match(
            '/^' . (str_replace('/', '\/', $arr)) . '$/',
            (strpos($uri, "/") !== 0) ? "/" . $uri : $uri,
            $matches,
            PREG_OFFSET_CAPTURE);
        if($is_match){
            $matches[] = $arr;
            return $matches;
        }
    }
    return false;
}