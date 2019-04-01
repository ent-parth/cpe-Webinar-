<?php

namespace App\Http\ResponseTransformers;

class ValidationResponseTransformer
{

    public function response($errors)
    {
        $transformed = "";
        foreach ($errors as $field => $message) {
            $transformed = $message;
            /*$transformed[] = [
                'field' => $field,
                'message' => (method_exists($this, 'message')) ? $this->container->call([
                    $this,
                    'message'
                ]) : $message[0]
            ];*/

//            $transformed =  (method_exists($this, 'message')) ? $this->container->call([$this, 'message']) : $message[0];
//            echo '<pre>'; print_r($transformed);
            break;
        }

        return $transformed;
    }
}
