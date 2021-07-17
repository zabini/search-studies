<?php

namespace App\Providers;

use App\Domains\Core\Domain\CompositionRepository;
use App\Domains\Core\Infra\Persistence\ElasticCompositionRepository;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(CompositionRepository::class, function ($app) {

            $client = ClientBuilder::create()
                ->setElasticCloudId(env('ELASTIC_CLOUD_ID'))
                ->setApiKey(env('ELASTIC_API_ID'), env('ELASTIC_API_KEY'))
                ->build();

            return new ElasticCompositionRepository($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
