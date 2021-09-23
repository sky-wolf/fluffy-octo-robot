<?php
namespace app\core\Validation\Forms;
use Respect\Validation\Validator as v;

class OrderForm
{

    protected $errors = [];
    protected $basket;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public static function rules()
    {
        
        return [
            'email-1-1' => v::email(),
'name1-1' => v::alpha(' åäö'),
'date1-1' => v::date(),
'ort1-1' => v::alpha(' åäö'),
'grupp1-1' => v::optional(v::alpha(' åäö')),
'email-1-2' => v::email(),
'name1-2' => v::alpha(' åäö'),
'date1-2' => v::date(),
'ort1-2' => v::alpha(' åäö'),
'grupp1-2' => v::optional(v::alpha(' åäö')),
'email-1-3' => v::email(),
'name1-3' => v::alpha(' åäö'),
'date1-3' => v::date(),
'ort1-3' => v::alpha(' åäö'),
'grupp1-3' => v::optional(v::alpha(' åäö')),
'email-1-4' => v::email(),
'name1-4' => v::alpha(' åäö'),
'date1-4' => v::date(),
'ort1-4' => v::alpha(' åäö'),
'grupp1-4' => v::optional(v::alpha(' åäö')),
'email-1-5' => v::email(),
'name1-5' => v::alpha(' åäö'),
'date1-5' => v::date(),
'ort1-5' => v::alpha(' åäö'),
'grupp1-5' => v::optional(v::alpha(' åäö')),
'email-1-6' => v::email(),
'name1-6' => v::alpha(' åäö'),
'date1-6' => v::date(),
'ort1-6' => v::alpha(' åäö'),
'grupp1-6' => v::optional(v::alpha(' åäö')),
'email-1-7' => v::email(),
'name1-7' => v::alpha(' åäö'),
'date1-7' => v::date(),
'ort1-7' => v::alpha(' åäö'),
'grupp1-7' => v::optional(v::alpha(' åäö')),
'email-1-8' => v::email(),
'name1-8' => v::alpha(' åäö'),
'date1-8' => v::date(),
'ort1-8' => v::alpha(' åäö'),
'grupp1-8' => v::optional(v::alpha(' åäö')),
'email-1-9' => v::email(),
'name1-9' => v::alpha(' åäö'),
'date1-9' => v::date(),
'ort1-9' => v::alpha(' åäö'),
'grupp1-9' => v::optional(v::alpha(' åäö')),
'email-1-10' => v::email(),
'name1-10' => v::alpha(' åäö'),
'date1-10' => v::date(),
'ort1-10' => v::alpha(' åäö'),
'grupp1-10' => v::optional(v::alpha(' åäö')),
'email-1-11' => v::email(),
'name1-11' => v::alpha(' åäö'),
'date1-11' => v::date(),
'ort1-11' => v::alpha(' åäö'),
'grupp1-11' => v::optional(v::alpha(' åäö')),
'email-1-12' => v::email(),
'name1-12' => v::alpha(' åäö'),
'date1-12' => v::date(),
'ort1-12' => v::alpha(' åäö'),
'grupp1-12' => v::optional(v::alpha(' åäö')),
'email-1-13' => v::email(),
'name1-13' => v::alpha(' åäö'),
'date1-13' => v::date(),
'ort1-13' => v::alpha(' åäö'),
'grupp1-13' => v::optional(v::alpha(' åäö')),
'email-1-14' => v::email(),
'name1-14' => v::alpha(' åäö'),
'date1-14' => v::date(),
'ort1-14' => v::alpha(' åäö'),
'grupp1-14' => v::optional(v::alpha(' åäö')),
'email-1-15' => v::email(),
'name1-15' => v::alpha(' åäö'),
'date1-15' => v::date(),
'ort1-15' => v::alpha(' åäö'),
'grupp1-15' => v::optional(v::alpha(' åäö')),
'email-1-16' => v::email(),
'name1-16' => v::alpha(' åäö'),
'date1-16' => v::date(),
'ort1-16' => v::alpha(' åäö'),
'grupp1-16' => v::optional(v::alpha(' åäö')),
'email-1-17' => v::email(),
'name1-17' => v::alpha(' åäö'),
'date1-17' => v::date(),
'ort1-17' => v::alpha(' åäö'),
'grupp1-17' => v::optional(v::alpha(' åäö')),
'email-1-18' => v::email(),
'name1-18' => v::alpha(' åäö'),
'date1-18' => v::date(),
'ort1-18' => v::alpha(' åäö'),
'grupp1-18' => v::optional(v::alpha(' åäö')),
'email-1-19' => v::email(),
'name1-19' => v::alpha(' åäö'),
'date1-19' => v::date(),
'ort1-19' => v::alpha(' åäö'),
'grupp1-19' => v::optional(v::alpha(' åäö')),
'email-1-20' => v::email(),
'name1-20' => v::alpha(' åäö'),
'date1-20' => v::date(),
'ort1-20' => v::alpha(' åäö'),
'grupp1-20' => v::optional(v::alpha(' åäö')),
'email-2-1' => v::email(),
'name2-1' => v::alpha(' åäö'),
'date2-1' => v::date(),
'ort2-1' => v::alpha(' åäö'),
'grupp2-1' => v::optional(v::alpha(' åäö')),
'email-2-2' => v::email(),
'name2-2' => v::alpha(' åäö'),
'date2-2' => v::date(),
'ort2-2' => v::alpha(' åäö'),
'grupp2-2' => v::optional(v::alpha(' åäö')),
'email-2-3' => v::email(),
'name2-3' => v::alpha(' åäö'),
'date2-3' => v::date(),
'ort2-3' => v::alpha(' åäö'),
'grupp2-3' => v::optional(v::alpha(' åäö')),
'email-2-4' => v::email(),
'name2-4' => v::alpha(' åäö'),
'date2-4' => v::date(),
'ort2-4' => v::alpha(' åäö'),
'grupp2-4' => v::optional(v::alpha(' åäö')),
'email-2-5' => v::email(),
'name2-5' => v::alpha(' åäö'),
'date2-5' => v::date(),
'ort2-5' => v::alpha(' åäö'),
'grupp2-5' => v::optional(v::alpha(' åäö')),
'email-2-6' => v::email(),
'name2-6' => v::alpha(' åäö'),
'date2-6' => v::date(),
'ort2-6' => v::alpha(' åäö'),
'grupp2-6' => v::optional(v::alpha(' åäö')),
'email-2-7' => v::email(),
'name2-7' => v::alpha(' åäö'),
'date2-7' => v::date(),
'ort2-7' => v::alpha(' åäö'),
'grupp2-7' => v::optional(v::alpha(' åäö')),
'email-2-8' => v::email(),
'name2-8' => v::alpha(' åäö'),
'date2-8' => v::date(),
'ort2-8' => v::alpha(' åäö'),
'grupp2-8' => v::optional(v::alpha(' åäö')),
'email-2-9' => v::email(),
'name2-9' => v::alpha(' åäö'),
'date2-9' => v::date(),
'ort2-9' => v::alpha(' åäö'),
'grupp2-9' => v::optional(v::alpha(' åäö')),
'email-2-10' => v::email(),
'name2-10' => v::alpha(' åäö'),
'date2-10' => v::date(),
'ort2-10' => v::alpha(' åäö'),
'grupp2-10' => v::optional(v::alpha(' åäö')),
'email-2-11' => v::email(),
'name2-11' => v::alpha(' åäö'),
'date2-11' => v::date(),
'ort2-11' => v::alpha(' åäö'),
'grupp2-11' => v::optional(v::alpha(' åäö')),
'email-2-12' => v::email(),
'name2-12' => v::alpha(' åäö'),
'date2-12' => v::date(),
'ort2-12' => v::alpha(' åäö'),
'grupp2-12' => v::optional(v::alpha(' åäö')),
'email-2-13' => v::email(),
'name2-13' => v::alpha(' åäö'),
'date2-13' => v::date(),
'ort2-13' => v::alpha(' åäö'),
'grupp2-13' => v::optional(v::alpha(' åäö')),
'email-2-14' => v::email(),
'name2-14' => v::alpha(' åäö'),
'date2-14' => v::date(),
'ort2-14' => v::alpha(' åäö'),
'grupp2-14' => v::optional(v::alpha(' åäö')),
'email-2-15' => v::email(),
'name2-15' => v::alpha(' åäö'),
'date2-15' => v::date(),
'ort2-15' => v::alpha(' åäö'),
'grupp2-15' => v::optional(v::alpha(' åäö')),
'email-2-16' => v::email(),
'name2-16' => v::alpha(' åäö'),
'date2-16' => v::date(),
'ort2-16' => v::alpha(' åäö'),
'grupp2-16' => v::optional(v::alpha(' åäö')),
'email-2-17' => v::email(),
'name2-17' => v::alpha(' åäö'),
'date2-17' => v::date(),
'ort2-17' => v::alpha(' åäö'),
'grupp2-17' => v::optional(v::alpha(' åäö')),
'email-2-18' => v::email(),
'name2-18' => v::alpha(' åäö'),
'date2-18' => v::date(),
'ort2-18' => v::alpha(' åäö'),
'grupp2-18' => v::optional(v::alpha(' åäö')),
'email-2-19' => v::email(),
'name2-19' => v::alpha(' åäö'),
'date2-19' => v::date(),
'ort2-19' => v::alpha(' åäö'),
'grupp2-19' => v::optional(v::alpha(' åäö')),
'email-2-20' => v::email(),
'name2-20' => v::alpha(' åäö'),
'date2-20' => v::date(),
'ort2-20' => v::alpha(' åäö'),
'grupp2-20' => v::optional(v::alpha(' åäö')),

        ];
    }
    
    public function rulesgen()
    {
        $errors = []; 
        $errors['semail'] = v::email();
        $errors['sname'] = v::alpha(" åäö");

        foreach($this->basket->all() as $item)
        {
            for ($i=1; $i <= $item->quantity; $i++) { 
                
                $errors['email-'.$i.'-'.$item->id] = v::email();
                $errors['name-'.$i.'-'.$item->id] = v::alpha(" åäö");
                $errors['date-'.$i.'-'.$item->id] = v::alpha(" åäö");
                $errors['ort-'.$i.'-'.$item->id] = v::alpha(" åäö");
                $errors['grupp-'.$i.'-'.$item->id] = v::optional(v::alpha(" åäö"));
            }        
        }
        return $errors;
    }
}