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
     * user accountType
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
    ],
    
    /**
     * Wave size drop down menu
     */
    'WAVE_SIZE'=>[
        '1'=>'1-3 FT',
        '2'=>'4-6 FT',
        '3'=>'7 FT+',
    ],
    
    /**
     * BOARD TYPE drop down menu
     */
    'BOARD_TYPE'=>[
        'SHORTBOARD'=>'Shortboard', 
        'GUN'=>'Gun', 
        'LONGBOARD'=>'Longboard', 
        'BODYBOARD'=>'Bodyboard', 
        'KNEEBOARD'=>'Kneeboard', 
        'BODYSURF'=>'Bodysurf'
    ],

    

    /****************************************************************************************************
     *                                              Error msg
     *****************************************************************************************************/
    'error'=>[
        'unauthorized'=>'You Are Not Authorized to Access This Page',
        'unauthorizedType'=>'You Are Not Authorized',
        'userCreate '=>'User account has been created successfully.!',
        "DEFAULT_ERROR"=> "Something went wrong!",
        "MODEL_ERROR"=>"Model not found",
    ],

    /****************************************************************************************************
     *                                              Success msg
     *****************************************************************************************************/
    'SUCCESS'=>[
        'UPDATE_SUCCESS'=>'Record has been successfully updated'
    ],
];