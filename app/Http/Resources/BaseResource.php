<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
   
     public static $wrap = 'results';

    public $code = 200;

    public $message = 'success';

    public function with($request)
    {
        return [
            'status' => $this->code,
            'message' => $this->message,
        ];
    }

     public static function collection($resource)
    {
        return new BaseCollection($resource, get_called_class());
    }

      public function setCode($code, $message = null)
    {
        $this->code = $code;

        if (!is_null($message)) {
            $this->message = $message;
        }
    }
}
