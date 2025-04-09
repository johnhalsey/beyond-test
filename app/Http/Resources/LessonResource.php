<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'start_at' => Carbon::parse($this->startAt)->format('d/m/Y H:i'),
            'end_at'   => Carbon::parse($this->endAt)->format('d/m/Y H:i'),
            'class'    => new ClassResource($this->class)
        ];
    }
}
