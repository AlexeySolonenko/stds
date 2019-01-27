<?php

function pr($a){
    echo "<pre>".print_r($a, true)."</pre>";
}

function nl(int $n = 1, bool $echo = true){
    $html = "";
    for($i = 0; $i < $n; $i++){
        if($echo === true){
            echo "<br />".PHP_EOL;
        } else {
            $html .= "<br />".PHP_EOL;
        }
    }
    if($echo === true){
        return true;
    } else {
        return $html;
    }
}


/**
 * extracts the full list of files from a directory
 */
function get_flat_files_array_from_dir(string $dir = __DIR__, int $type = -1, int $depth = 5, $level = 0, string $subPath = "") {
    $r = \Stds\Types\AjaxResponseSingle::singleton();
     /* if someone is trying ot access directories level up of wp protected upload dir = return */
    if(in_array($dir,['.','..'])) {
        return [];
    }
    /* all pathes are resolved only in relation to the wp protected uploads dir */
    $root =  wp_upload_dir();
    /* in case a dir or subPath is supplied with a trailing slash, remove it, */
    $dir = ltrim(rtrim($dir,'/'),'/');
    $basePath = rtrim($root['basedir'],'/').'/'.$dir.'/';
    if (!empty($subPath)) {
        $subPath = rtrim(ltrim($subPath, '/'), '/').'/';
    }
    $baseUrl = rtrim($root['baseurl'],'/').'/'.$dir.'/';
    /* prevent attacks on a server and prevent eternal loops */
    if($level >= $depth || $level > 10) {
        return [];
    }

    /* increment nesting */
    $level++;
    
    /* get dirs/files, if any, otherwise return */
     if(!file_exists($basePath.$subPath)) {
        return [];
    }
    $currentList = scandir($basePath.$subPath);
    if(!$currentList || !is_array($currentList)){
        return [];
    }
    /* init vars */
    $list =[];
    /* handle files extensions */
    if(!$type > 0) {
        $exts = \Stds\Types\Sys::MEDIA_TYPES[$type];
        if(empty($exts)){
            $exts = -1;
        }
    } else {
        $exts = -1;
    }
    // @todo avoid calling upload dir each time
    $ret = wp_upload_dir();
   
    
    /* handle scandir results */ 
    foreach($currentList as $entry){
        // if a root or level up - continue
        if(in_array($entry,[".",".."])) {
            continue;
        }
        /* if a dir - recur to itself */
        if(is_dir($basePath.$subPath.$entry)) {
            $list = array_merge($list, get_flat_files_array_from_dir($dir,$type, $depth,$level,$subPath.$entry));
        } else {
            /* else populate unique results into an array */
            $paths = array_column($list,'path');
            if(!in_array($basePath.$subPath.$entry,$paths)){
                $list[] = [
                    'path' => $basePath.$subPath.$entry,
                    'baseurl' => $baseUrl.$subPath.$entry,
                ];
            }
        }
    }
    
    return $list;
}
