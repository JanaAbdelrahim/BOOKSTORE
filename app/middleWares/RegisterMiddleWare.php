<?php


require_once __DIR__ . "/MiddleWare.php";

class RegisterMiddleWare implements MiddleWare{
    public function handle(string ...$rules):void{
        if(isAuth('customer')){
            redirect('/profile');
        }
    }
}
