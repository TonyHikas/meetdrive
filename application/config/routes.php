<?php

return [
    //Glav - Главный контроллер
    ''=>[
        'controller' => 'glav',
        'action' => 'index',
    ],
    'all'=>[
        'controller' => 'glav',
        'action' => 'all',
    ],
    'all/{page:\d+}'=>[
        'controller' => 'glav',
        'action' => 'all',
    ],
    'event/{alias:\w+}'=>[
        'controller' => 'glav',
        'action' => 'event',
    ],
    'event/{alias:\w+}/enter'=>[
        'controller' => 'glav',
        'action' => 'enter',
    ],
    'event/{alias:\w+}/edit'=>[
        'controller' => 'glav',
        'action' => 'edit',
    ],
    'event/{alias:\w+}/exit'=>[
        'controller' => 'glav',
        'action' => 'exit',
    ],
    //Profile - Профиль
    'profile'=>[
        'controller' => 'profile',
        'action' => 'main',
    ],
    'profile/login'=>[
        'controller' => 'profile',
        'action' => 'login',
    ],
    'profile/register'=>[
        'controller' => 'profile',
        'action' => 'register',
    ],
    'profile/logout'=>[
        'controller' => 'profile',
        'action' => 'logout',
    ],
    'profile/confirm/{id:\d+}/{key:\w+}'=>[
        'controller' => 'profile',
        'action' => 'confirm',
    ],
    'profile/restore'=>[
        'controller' => 'profile',
        'action' => 'restore',
    ],
    'profile/restorekey'=>[
        'controller' => 'profile',
        'action' => 'restorekey',
    ],

    //Редактирование данных аккаунта
    'profile/emailchange'=>[
        'controller' => 'profile',
        'action' => 'emailchange',
    ],
    'profile/passchange'=>[
        'controller' => 'profile',
        'action' => 'passchange',
    ],
    'profile/datachange'=>[
        'controller' => 'profile',
        'action' => 'datachange',
    ],
    //Avto
    'profile/myavto'=>[
        'controller' => 'avto',
        'action' => 'myavto',
    ],
    'profile/myavto/{page:\d+}'=>[
        'controller' => 'avto',
        'action' => 'myavto',
    ],
    'profile/myavto/edit/{id:\d+}'=>[
        'controller' => 'avto',
        'action' => 'editAvto',
    ],
    'profile/myavto/edit'=>[
        'controller' => 'avto',
        'action' => 'editAvto',
    ],
    'profile/myavto/add'=>[
        'controller' => 'avto',
        'action' => 'addAvto',
    ],
    'profile/myavto/delete/{id:\d+}'=>[
        'controller' => 'avto',
        'action' => 'deleteAvto',
    ],
    //event
    'profile/myevent'=>[
        'controller' => 'event',
        'action' => 'myevent',
    ],
    'profile/myevent/{page:\d+}'=>[
        'controller' => 'event',
        'action' => 'myevent',
    ],
    'profile/archivemyevent'=>[
        'controller' => 'event',
        'action' => 'archivemyevent',
    ],
    'profile/archivemyevent/{page:\d+}'=>[
        'controller' => 'event',
        'action' => 'archivemyevent',
    ],

    'profile/myevent/edit/{id:\d+}'=>[
        'controller' => 'event',
        'action' => 'editEvent',
    ],
    'profile/myevent/edit'=>[
        'controller' => 'event',
        'action' => 'editEvent',
    ],
    'profile/myevent/add'=>[
        'controller' => 'event',
        'action' => 'addEvent',
    ],
    'profile/myevent/delete/{id:\d+}'=>[
        'controller' => 'event',
        'action' => 'deleteEvent',
    ],
    'profile/myevent/create'=>[
        'controller' => 'event',
        'action' => 'createCompany',
    ],
    'profile/myevent/update'=>[
        'controller' => 'event',
        'action' => 'updateCompany',
    ],
    'profile/podt'=>[
        'controller' => 'profile',
        'action' => 'podt',
    ],
    //участие в мероприятиях
    'profile/active'=>[
        'controller' => 'event',
        'action' => 'active',
    ],
    'profile/archive'=>[
        'controller' => 'event',
        'action' => 'archive',
    ],
    'profile/active/{page:\d+}'=>[
        'controller' => 'event',
        'action' => 'active',
    ],
    'profile/archive/{page:\d+}'=>[
        'controller' => 'event',
        'action' => 'archive',
    ],



    //d - цифры, w - любые символы
    //Admin - Админ панель
    'admin'=>[
        'controller' => 'admin',
        'action' => 'main',
    ],
    'admin/login'=>[
        'controller' => 'admin',
        'action' => 'login',
    ],

    'admin/addNews'=>[
        'controller' => 'admin',
        'action' => 'add',
        ],

    'admin/editNews/{id:\d+}'=>[
        'controller' => 'admin',
        'action' => 'edit',
    ],
    'admin/deleteNews/{id:\d+}'=>[
        'controller' => 'admin',
        'action' => 'delete',
    ],
    'admin/logout'=>[
        'controller' => 'admin',
        'action' => 'logout',
    ],
    'admin/params'=>[
        'controller' => 'admin',
        'action' => 'params',
    ],
    'admin/editParams/{id:\d+}'=>[
        'controller' => 'admin',
        'action' => 'editParams',
    ],
    'admin/editParams'=>[
        'controller' => 'admin',
        'action' => 'editParamsGo',
    ],

    //Input get
    'input/carBrands'=>[
        'controller' => 'input',
        'action' => 'getCarBrands',
    ],
];