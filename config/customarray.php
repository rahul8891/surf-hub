<?php
use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;
return [   
    
    /**********************************************************************************************************
     *                                  Enum Data Type
     **********************************************************************************************************/
    // User Type 
     'userType'=>[
        'ADMIN'=>'ADMIN',
        'USER'=>'USER'
    ],

    
     // User status    
    'status'=>[
        'ACTIVE'=>'ACTIVE',
        'PENDING'=>'PENDING',
        'DEACTIVATED'=>'DEACTIVATED'
    ],

    // Set language for drop down
    'language'=>[
        'en'=>'English',
        'es'=>'Spanish'
    ],

    // User accountType
    'accountType'=>[
        'PUBLIC'=>'Public',
        'PRIVATE'=>'Private'
    ],

    // Post post_type
    'post_type'=>[        
        'PRIVATE'=>'MyHub',
        'PUBLIC'=>'MyHub & Post'
    ],

    // Wave size drop down menu
    'wave_size'=>[
        '1'=>'1-2 FT',
        '2'=>'3-4 FT',
        '3'=>'5-6 FT',
        '4'=>'7 FT+',
    ],
    
    // BOARD TYPE drop down menu
    'board_type'=>[
        'SHORTBOARD'=>'Shortboard', 
        'GUN'=>'Gun', 
        'LONGBOARD'=>'Longboard', 
        'BODYBOARD'=>'Bodyboard', 
        'KNEEBOARD'=>'Kneeboard', 
        'BODYSURF'=>'Bodysurf'
    ],


    // Optional Info drop down menu
    'optional'=>[
        'FLOATER'=>'Floater', 
        'DROP_IN'=>'Drop In', 
        'CUTBACK'=>'Cutback', 
        'AIR'=>'Air', 
        'BARREL_ROLL'=>'Barrel Roll', 
        'SNAP'=>'Snap',
        '360'=>'360',
        'WIPEOUT'=>'Wipeout',
    ],
    
    'surfer'=>[
        'ME'=>'Me',
        'OTHERS'=>'Others',
        'UNKNOWN'=>'Unknown'
    ],

     /**********************************************************************************************************
     *                                  Global Access Data
     **********************************************************************************************************/
    
    // image storage path
    'image_path'=>'/storage/images',

    // Admin dashboard redirect 
    'adminhome' => RouteServiceProvider::ADMINHOME,

    // Site Title for user and admin
    'siteTitle'=> [
        'admin'=>'Surf Hub Admin',
        'user'=>'Surf Hub'
    ],
    
    
    

    /****************************************************************************************************
     *                                              Error/Succcess Message
     *****************************************************************************************************/
    
     'common'=>[
        'unauthorized'=>'You Are Not Authorized to Access This Page',
        'unauthorizedType'=>'You Are Not Authorized',
        'userCreate '=>'User account has been created successfully.!',
        'DEFAULT_ERROR'=> 'Something went wrong!',
        'MODEL_ERROR'=>'Model not found',
        'SERVER_ERROR'=> 'Internal Server Error.',
        'LOGIN_FAILED_EMAIL_NOT_VERIFIED'=> 'Please verify your email to login!',
        'AUTHORIZATION_REQUIRED'=> 'Access Denied - Authorization required',
        'EMAIL_DUPLICATE'=> 'Email already registered with us!',
        'BLOCKED_USER'=> 'This account has been blocked / Restricted! Please connect us for furthur instructions.',
        'ACTION_NOT_ALLOWED'=> 'User is not allowed to perform this action!',
        'PASSWORD_RESET_MAIL_SENT'=> 'Password reset mail sent successfully.',
        'PASSWORD_RESET_SUCCESS'=> 'Password has been reset successfully.',
        'PASSWORD_CHANGE_SUCCESS'=> 'Password has been changed successfully.',
        'MODEL_NOT_FOUND'=>'Requested entity does not exists!',
        'NO_FILE_SELECTED'=> 'Please select a file to upload!',
        'NO_RECORDS'=> 'No record found!',
        'UPDATE_SUCCESS'=> 'updated successfully.'
     ],

    'error'=>[
        'unauthorized'=>'You Are Not Authorized to Access This Page',
        'unauthorizedType'=>'You Are Not Authorized',
        'userCreate '=>'User account has been created successfully.!',
        "DEFAULT_ERROR"=> "Something went wrong!",
        "MODEL_ERROR"=>"Model not found",
    ],
     
    'success'=>[
        'UPDATE_SUCCESS'=>'Record has been successfully updated'
    ],
];