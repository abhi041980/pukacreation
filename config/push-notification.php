<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'development',
        'certificate' =>'/path/to/certificate.pem',
        'passPhrase'  =>'password',
        'service'     =>'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>'AAAAiObU7x0:APA91bFDagfZzgUKBpcAOeMXxutLGAhHLWilJ3AFsWMG-y-ylbabRzS8HGnNMvcZo5MnU986sRxdn4-1Fa_BBHh8eC2c_YUHtGNuNBzM7CSiYxMk5UJNOAcQzJAAcPN_X3TjfwklISx8',
        'service'     =>'gcm'
    )

);