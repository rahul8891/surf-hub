<?php
use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;
return [   
    
    /**
     * set user type
     */
    'userType'=>[
        'ADMIN'=>'ADMIN',
        'USER'=>'USER'
    ],

    /**
     * set user status
     */
    'status'=>[
        'ACTIVE'=>'ACTIVE',
        'PENDING'=>'PENDING',
        'DEACTIVATED'=>'DEACTIVATED'
    ],

    /**
     * Set language for drop down
     */
    'language'=>[
        'en'=>'English',
        'es'=>'Spanish'
    ],

    /**
     * 
     */
    'accountType'=>[
        'PUBLIC'=>'Public',
        'PRIVATE'=>'Private'
    ],

    // image storage path
    'image_path'=>'/storage/images',

    // Admin dashboard redirect 
    'adminhome' => RouteServiceProvider::ADMINHOME,

    /**
     * Site Title for user and admin
     */
    'siteTitle'=> [
        'admin'=>'Surf Hub Admin',
        'user'=>'Surf Hub'
    ]
];