<?php
namespace app\core\Validation\Forms;
use Respect\Validation\Validator as v;

class AuthForm
{

    public static function signup()
    {
        
        return [
            'email' => v::email(),
            'username' => v::alpha(),
            'losenord' => v::alnum(),
        ];
    }

    public static function signin()
    {
        
        return [
            'username' => v::alpha(),
            'losenord' => v::alnum(),
        ];
    }
}
