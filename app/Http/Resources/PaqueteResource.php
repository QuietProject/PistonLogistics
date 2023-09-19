<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Paquete;
use Mockery\Generator\StringManipulation\Pass\Pass;

class PaqueteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function index()
    {
        $paquetes = Paquete::paginate();
        return PaqueteResource::collection($paquetes);
    }
}
