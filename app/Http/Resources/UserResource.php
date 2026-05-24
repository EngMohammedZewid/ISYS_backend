<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->full_name,
            'email' => $this->email,
            'qrcode' => 'data:image/png;base64,'.base64_encode($this->qrcode),
            'phoneNumber' => $this->phone_number,
            'jobTitle' => $this->job_title,
            'companyName' => $this->company_name,
            'adminPromoted' => $this->admin_promoted,
            'emailVerifiedAt' => $this->email_verified_at,
            'type' => $this->type,
        ];
    }
}
