<?php

namespace app\core\Validation;

use app\core\Request;


class Validator
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';

    protected array  $errors = [];

    public function validate(Request $request, array $rules)
    {
        foreach ($rules as $field => $rule)
        {
            echo ucfirst($field). '<br>';
            
            /* try
            {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            }
            catch (NestedValidationException $e)
            {
                $this->errors[$field] = $e->getMessages();
            } */
        }
        
        if(($request->getParam('password') === $request->getParam('repeteralosenord')))
        {
            $this->errors['repeteralosenord'] = 'Lösenordet var inte samma';
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function fails()
    {
        return !empty($this->errors);
    }
}