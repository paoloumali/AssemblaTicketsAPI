<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

use Pimple\Container;
use GuzzleHttp\Client as HttpClient;



class BaseAPI extends Container
{
    const INIT_OPTIONS = [
        'ASSEMBLA_KEY' => null,
        'ASSEMBLA_SECRET' => null,
        'ASSEMBLA_SPACE' => 'PO-Migrations',
        'api_url' => null
    ];

    private $c;
    private $moreOptions = [];

    protected function buildUrl($c) {
        return $c['base_url'];
    }

    public static function init( $input_options = self::INIT_OPTIONS) {
        return new static($input_options);
    }

    protected function _mergeOptions($inputOptions)
    {
        $this->c['input_options'] = $inputOptions;

        $this->c['options'] =
            array_merge(static::INIT_OPTIONS,
            $this->moreOptions,
            $this->c['input_options']);
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

    protected function _bootstrap()
    {
        // setup the http client
        $this->c['http_client'] = $this->c->factory(fn($c) => new HttpClient());

        // headers
        $this->c['context'] = [
            'headers' => [
                'X-Api-Key' => $this->c['options']['ASSEMBLA_KEY'] ,
                'X-Api-Secret' => $this->c['options']['ASSEMBLA_SECRET']
            ]
        ];

        // setup base url
        $this->c['base_url'] = 'https://api.assembla.com/v1/spaces/'.$this->c['options']['ASSEMBLA_SPACE'];

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
