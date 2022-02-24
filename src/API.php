<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

use Pimple\Container;
use GuzzleHttp\Client as HttpClient;

class API
{

    private $container;

    public function __construct($options = [
        'X-Api-Key' => null,
        'X-Api-Secret' => null,
        'space' => 'PO-Migrations'
    ]){

        $this->container = new Container();
        $this->c = &$this->container;

        $this->updateOptions($options);

        $this->_setupHeaders();

        $this->setupApiUrl();

        $this->_setupGuzzleGet();
    }


    public function c()
    {
        return $this->c;
    }

    public function getContainer()
    {
        return $this->c;
    }

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

    protected function setupApiUrl()
    {
        $this->c['getApiUrl'] = $this->c->factory(fn($c) => function($resource=null) use($c){

            $base_url = 'https://api.assembla.com/v1/spaces' . (is_null($c['options']['space']) ?
                '' :
                '/' . $c['options']['space']);

            $c['url'] = $base_url;

            if (filter_var($c['options']['url'], FILTER_VALIDATE_URL))
                $c['url'] = $c['options']['url'];

            if ($c['options']['subpath'])
                $c['url'] = $base_url . '/' . $c['options']['subpath'];

            return $c['url'];
        });
    }

    private function _setupHeaders()
    {
        $this->c['context'] = [
            'headers' => [
                'X-Api-Key' => $this->c['options']['X-Api-Key'] ?: $_ENV['ASSEMBLA_API_KEY'],
                'X-Api-Secret' => $this->c['options']['X-Api-Secret'] ?: $_ENV['ASSEMBLA_API_SECRET']
            ]
        ];
    }

    private function _setupGuzzleGet()
    {

        $this->c['http_client'] = $this->c->factory(fn($c) => new HttpClient());

        $this->c['fetch'] = $this->c->factory(fn($c) => function() use($c){
            $response = $c['http_client']
                ->request('GET', $c['getApiUrl'](), $c['context']);

            return json_decode($response->getBody()->getContents());
        });
    }

    public function __call($method, $args) {
        return call_user_func_array($this->c[$method], $args);
    }
}
