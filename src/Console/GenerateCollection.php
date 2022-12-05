<?php

namespace Celysium\GenerateApiCollection\Console;

use Celysium\Router\Fecades\Router;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateCollection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:collection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store api collection to disk';

    /** @var string */
    protected string $baseUrl;

    /** @var array */
    protected array $structure;

    /** @var array */
    protected $config;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->loadConfig();

        $this->baseUrl();

        $this->fillStructure();

        $this->items();

        $this->store();

        return 0;
    }

    protected function loadConfig()
    {
        $this->config = config('generate_collection');
    }

    protected function baseUrl(): void
    {
        $this->baseUrl = $this->config['base_url'];
    }

    protected function fullUrl(string $url): string
    {
        return $this->baseUrl . $url;
    }

    protected function fillStructure(): void
    {
        $this->structure = [
            'variable' => [
                [
                    'key' => 'base_url',
                    'value' => $this->config['base_url'],
                ],
            ],
            'info' => [
                'name' => 'postman.json',
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
            ],
            'item' => [],
            'event' => [],
        ];
    }

    protected function items(): void
    {
        $items = Router::get();

        foreach ($items as $item) {
            $data = [
                'request' => [
                    'name' => $item['path'],
                    'method' => $item['method'],
                    'url' => [
                        'raw' => $this->fullUrl($item['url']),
                        'host' => $this->fullUrl($item['url']),
                    ]
                ]
            ];
            $this->structure['item'][] = $data;
        }
    }

    protected function store(): void
    {
        Storage::put("postman.json", json_encode($this->structure));
    }
}