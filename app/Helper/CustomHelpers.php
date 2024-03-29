<?php
use Carbon\Carbon;

/**
 *  active child menu
 */
function activeMenu($uri = '') {       
    $name = Route::currentRouteName();    
    $active = '';       
    if($name === $uri ){
        $active = 'active';
    }       
    return $active;
}

/**
 * Active opened menu
 */
function menuOpen($routeFor = '') {     
    $selectedMenu = Request::segment(2);
    $menuOpen = '';
    if($routeFor === $selectedMenu){
        $menuOpen = 'menu-open';
    }
    return $menuOpen;   
}

/**
 * Active main menu drop down
 */
function activeMainMenu($routeFor = '') {  
    $selectedMenu = Request::segment(2);
    $activeMainMenu = '';    
    $activeMainMenu = '';
    if($routeFor === $selectedMenu){
        $activeMainMenu = 'active';
    }
    return $activeMainMenu;
}


/**
 * Active User Feed menu
 */
function userActiveMenu($uri = '') {
    $name = Route::currentRouteName();    
    // echo $uri." -- ".$name;die('aa');
    $active = '';       
    if($name == $uri ){
        $active = 'active';
    }  

    return $active;
}

/**
 * posted date time ago
 */
function postedDateTime($dateTime = null) {       
    $created = Carbon::createFromTimeStamp(strtotime($dateTime))->diffForHumans();
    return $created;
}