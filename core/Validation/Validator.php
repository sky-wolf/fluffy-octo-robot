<?php

namespace app\core\Validation;

use app\core\Request;
use app\core\Validation\Rule\Rule;

class Validator
{
    protected array $rules = [];

    public function __construct() {
       $this->addRule('required', new Rule\RequiredRule());
        //$this->addRule('email', new Rule\EmailRule());
        //$this->addRule('min', new Rule\MinRule());
    }

    public function addRule(string $alias, Rule $rule)
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(Request $request, array $rules)
    {
        $errors = [];
        $data = $request->getBody();
        echo '<pre>';
		var_dump ($this->rules);
		echo '</pre>';
        
        foreach ($rules as $field => $rulesForField) 
        {
            foreach ($rulesForField as $rule)
            {
                
                $name = $rule;
                $params = [];

                if(str_contains($rule, ':'))
                {
                    [$name, $params] = explode(':', $rule);
                    $params = explode(',', $params);
                }

                $processor = $this->rules[$name];

                if(!$processor->validate($data, $field, $params))
                {
                    if(!isset($errors[$field]))
                    {
                        $errors[$field] = [];
                    }

                    array_push($errors[$field], $processor->getMassage($data, $field, $params));
                }
            
            }
           echo '<br>';
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