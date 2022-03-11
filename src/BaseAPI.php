<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

use Pimple\Container;
use GuzzleHttp\Client as HttpClient;

class BaseAPI extends Container
{
    private $c;

    protected function _mergeOptions($inputOptions)
    {
        $this->c['input_options'] = $inputOptions;

        $this->c['default_options'] = [
            'X-Api-Key' => null,
            'X-Api-Secret' => null,
            'space' => 'PO-Migrations',
            'api_url' => null,
            'milestone' => null,
            'params' => null,
        ];

        $this->c['options'] = array_merge($this->c['default_options'], $this->c['input_options']);
    }

    protected function __construct($inputOptions)
    {
        parent::__construct();
        $this->c = $this;

        $this->_mergeOptions($inputOptions);
        $this->_bootstrap();
        $this->prepApiUrl();
    }

    public function c()
    {
        return $this->c;
    }

    protected function prepApiUrl()
    {
        $this->c['getApiUrl'] = $this->c->factory(fn($c) => function() use($c){

            return $c['options']['api_url']?:$this->buildUrl($c);
        });
    }

    protected function buildUrl($c) {
        return $c['base_url'];
    }

    public static function init( $input_options = [
        'X-Api-Key' => null,
        'X-Api-Secret' => null,
        'space' => 'PO-Migrations'
    ]) {
        return new static($input_options);
    }

    protected function _bootstrap()
    {
        // setup the http client
        $this->c['http_client'] = $this->c->factory(fn($c) => new HttpClient());

        // headers
        $this->c['context'] = [
            'headers' => [
                'X-Api-Key' => $this->c['options']['X-Api-Key'] ?: $_ENV['ASSEMBLA_API_KEY'],
                'X-Api-Secret' => $this->c['options']['X-Api-Secret'] ?: $_ENV['ASSEMBLA_API_SECRET']
            ]
        ];

        // setup base url
        $this->c['base_url'] = 'https://api.assembla.com/v1/spaces/'.$this->c['options']['space'];

        // define fetch
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
