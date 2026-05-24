<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionTrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $transformedData = [];

        foreach ($this->sessions as $session) {
            $sessionData = [
                'time' => $session->from->format('h:i A').' - '.$session->to->format('h:i A'),
                'topic' => $session->title,
                'speakers' => $session->speaker.' - '.$session->speaker_job_title,
            ];

            $transformedData[] = $sessionData;
        }

        return [
            'time' => $this->from->format('h:i A').' - '.$this->to->format('h:i A'),
            'sessions' => $transformedData,
        ];
    }
}
