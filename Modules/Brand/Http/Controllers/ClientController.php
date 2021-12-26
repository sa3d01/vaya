<?php

namespace Modules\Brand\Http\Controllers;


use App\Models\Client;
use Modules\Brand\Transformers\ClientDTO;


class ClientController extends MasterController
{
    public function profile($id)
    {
        $client = Client::find($id);
        return $this->sendResponse(new ClientDTO($client));
    }

}
