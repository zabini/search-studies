<?php

use App\Http\Controllers\CompositionController;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/composition/{id}', [CompositionController::class, 'get']);

Route::get('/', function (Request $request) {

    $client = ClientBuilder::create()
        ->setElasticCloudId(env('ELASTIC_CLOUD_ID'))
        ->setApiKey(env('ELASTIC_API_ID'), env('ELASTIC_API_KEY'))
        ->build();

    $params = [
        'index' => 'composition',
    ];

    $results = $client->search($params);

    return $results;
});

Route::get('/create', function (Request $request) {

    $client = ClientBuilder::create()
        ->setElasticCloudId(env('ELASTIC_CLOUD_ID'))
        ->setApiKey(env('ELASTIC_API_ID'), env('ELASTIC_API_KEY'))
        ->build();

    $params = [
        'index' => 'composition'
    ];

    // Create the index
    $response = $client->indices()->create($params);

    return $response;
});

Route::get('/store/{id}', function (string $id, Request $request) {

    $client = ClientBuilder::create()
        ->setElasticCloudId(env('ELASTIC_CLOUD_ID'))
        ->setApiKey(env('ELASTIC_API_ID'), env('ELASTIC_API_KEY'))
        ->build();

    return $client->index([
        'index' => 'composition',
        'id' => $id,
        'body' => [
            'description' => $request->input('desc', 'Estrombelhete de pombo obeso'),
        ],
    ]);
});
