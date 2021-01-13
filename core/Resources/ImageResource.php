<?php

namespace Core\Resources;

use Core\Abstracts\CoreResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class ImageResource
 * @package Core\Resources
 * @mixin Media
 */
class ImageResource extends CoreResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'collection_name' => $this->collection_name,
            'files'           => [
                'original'   => $this->getFullUrl(),
                'thumbnails' => [
                    '_50'  => $this->getFullUrl('50'),
                    '_100' => $this->getFullUrl('100'),
                ],
            ],
        ];
    }
}
