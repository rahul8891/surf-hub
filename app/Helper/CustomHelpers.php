<?php


function activeMenu($uri = '') {       
    $name = Route::currentRouteName();    
    $active = '';       
    if($name === $uri ){
        $active = 'active';
    }       
    return $active;
}


function menuOpen($routeFor = '') {     
    $selectedMenu = Request::segment(2);
    $menuOpen = '';
    if($routeFor === $selectedMenu){
        $menuOpen = 'menu-open';
    }
    return $menuOpen;   
}


function activeMainMenu($routeFor = '') {  
    $selectedMenu = Request::segment(2);
    $activeMainMenu = '';    
    $activeMainMenu = '';
    if($routeFor === $selectedMenu){
        $activeMainMenu = 'active';
    }
    return $activeMainMenu;
}

