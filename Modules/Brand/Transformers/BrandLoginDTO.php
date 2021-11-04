<?php

namespace Modules\Brand\Transformers;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandLoginDTO extends JsonResource
{
    public function toArray($request)
    {
        $tokenResult = $this->createToken('Brand');
        $tokenResult->token->expires_at = Carbon::now()->addWeeks(5);
        return [
            "user" => new BrandOwnerDTO($this),
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
