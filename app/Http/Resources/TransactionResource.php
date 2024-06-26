<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'reference' => $this->reference,
            'amount' => $this->amount,
            'status' => $this->status,
            'type' => $this->type,
            'date' => Carbon::parse()->format('d-m-y H:i '),
            'description' => strlen($this->description) > 100 ? substr($this->description, 0, 100) . '...' : $this->description
        ];
    }
}
