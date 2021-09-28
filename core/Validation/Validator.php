<?php

namespace app\core\Validation;

use app\core\Request;

class Validator
{
    protected array $rules = [];

    public function __construct() {
        $this->addRule('required', new RequiredRule());
        $this->addRule('email', new EmailRule());
        $this->addRule('min', new MinRule());
    }

    public function addRule(string $alias, Rule $rule)
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(Request $request, array $rules)
    {
        $errors = [];
        $data = $request->getBody();
        
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

                    array_push($errors[$field], $processor->getMessage($data, $field, $params));
                }    
            }
        }
            
        if(count($errors))
        {   
            $test = array_intersect_key($data, $rules);
            echo '<pre>';
            var_dump ($errors);
            var_dump ($test);
            echo '</pre>';
        }    
            
        

        $_SESSION['errors'] = $errors;

        return $this;
    }

    public function fails()
    {
        return !empty($this->errors);
    }
}