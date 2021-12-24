<?php

namespace Modules\Client\Transformers;
use App\Models\ClientAddress;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientLoginDTO extends JsonResource
{
    public function toArray($request)
    {
        $tokenResult = $this->createToken('Client');
        $tokenResult->token->expires_at = Carbon::now()->addWeeks(5);
        $addresses = ClientAddress::where('client_id', $this->id)->get();

        return [
            "user" => new ClientDTO($this),
            "addresses"=>AddressDTO::collection($addresses),
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
