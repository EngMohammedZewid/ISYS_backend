<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionDetailsResource extends JsonResource
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
            'title' => $this->title,
            'date' => $this->date,
            'from' => Carbon::parse($this->from)->format('h:i A'),
            'to' => Carbon::parse($this->to)->format('h:i A'),
            'live_link' => $this->live_link,
            'link' => $this->link,
            'speaker' => $this->speaker,
            'speaker_job_title' => $this->speaker_job_title,
        ];
    }
}
