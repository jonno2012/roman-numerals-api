<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ConversionTransformer extends TransformerAbstract
{
    /**
     * @param array $conversion
     * @return array
     */
    public function transform(array $conversion)
    {
        return [
            'id' => $conversion['id'],
            'integer' => $conversion['integer'],
            'numeral' => $conversion['numeral'],
            'count' => $conversion['count'],
        ];
    }
}
