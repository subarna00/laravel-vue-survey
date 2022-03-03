<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class SurveyDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'survey' => $request->survey
            // 'id' => $this->id,
            // 'title' => $this->title,
            // 'image_url' => $this->image ? URL::to($this->image) : null,
            // 'slug' => $this->slug,
            // 'status' => $this->status !== 'draft',
            // 'created_at' => $this->created_at,
            // 'client' => $this->client,
            // 'employe' => $this->employe,
        ];
    }
}
