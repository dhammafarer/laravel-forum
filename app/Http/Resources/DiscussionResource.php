<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DiscussionResource
 *
 * @mixin \App\Models\Discussion
 * */
class DiscussionResource extends JsonResource
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
            'slug' => $this->slug,
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'is_pinned' => $this->isPinned(),
        ];
    }
}
