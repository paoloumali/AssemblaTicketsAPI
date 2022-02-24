<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

final class UserAPI extends API
{
    public function updateOptions($options = [])
    {
        $default_options = [
            'X-Api-Key' => null,
            'X-Api-Secret' => null,
            'space' => 'PO-Migrations',
            'url' => null,
            'subpath' => null,
            'milestone' => null,
            'params' => null,
        ];
        $this->c['options'] = array_merge($default_options, $options);
    }
}
