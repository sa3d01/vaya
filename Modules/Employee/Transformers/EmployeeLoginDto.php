<?php

namespace Modules\Employee\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeLoginDto extends JsonResource
{
    public function toArray($request)
    {
        $tokenResult = $this->createToken('Employee');
        $tokenResult->token->expires_at = Carbon::now()->addWeeks(5);
        return [
            "user" => new BrandEmployeeDTO($this),
            "settings" => [
                'banned' => (boolean)$this->banned,
            ],
            "access_token" => [
                'token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ],
        ];
    }

}
