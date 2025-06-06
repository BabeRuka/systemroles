# to-do
```
edit the query on this page
AdminUsersController.php
move the query from this page
AdminPagesController.php
AdminUsersController.php

edit this function (function userdata()) in AdminUsersController.php to use datatables
```
# missing
```
The middleware below are in the kernel.php file but missing in the middleware folder
\App\Http\Middleware\SessionCheckMiddleware::class,
\App\Http\Middleware\CustomMiddleware::class,

  protected $routeMiddleware = [
        'session.expired' => \App\Http\Middleware\SessionExpired::class,   
        'session.check' => \App\Http\Middleware\SessionCheckMiddleware::class,
        'initiate.session' => \App\Http\Middleware\InitiateSession::class,
    ];
```
### Edit again
```
All the models. Create proper relationships using foreign keys
Add the definations in the files

UserFieldDetails.php
```

```
### Include
<script src="{{ asset('addons/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/dropify/js/dropify.min.js') }}"></script>