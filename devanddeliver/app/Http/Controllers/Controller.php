<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function connectToAPI($method, $url, $data = null, $response = null) {
        $http = new Client([
            'base_uri' => 'https://swapi.dev/api/',
            'verify' => false
        ]);
        $cache = $this->cacheExists($url);
        if ($cache) {
            return $cache;
        }
        switch ($method) {
            case 'GET':
                $response = $http->get($url);
                break;
            case 'POST':
                $response = $http->post($url, $data);
                break;
            default:
                break;
        }
        if ($response->getStatusCode() === 200) {
            Cache::put($url, json_decode($response->getBody()->getContents()));
            return Cache::get($url);
        }
        return false;
    }

    protected function getRandomHero() {
        $response = $this->connectToAPI('GET', 'people');
        if ($response) {
            $heroId = (rand(1, $response->count + 1));
            $hero = $this->getDataById($heroId);
            if (is_object($hero)) {
                return $heroId;
            }
            return false;
        }
        return false;
    }

    protected function getDataById($id) {
        $data = $this->connectToAPI('GET', 'people/' . $id);
        if (!is_object($data)) {
            return false;
        }
        return $data;
    }

    protected function getResource($resource, $id) {
        $data = $this->getDataById(auth()->user()->hero_id);
        if(!$data) {
            return false;
        }

        if ($resource === 'planets') {
            $resourceData = $data->homeworld;
        } else {
            if (!property_exists($data, $resource)) {
                return false;
            }
            $resourceData = $data->$resource;
        }

        if (!$id) {
            return [
                $resource => [
                    $resourceData
                ]
            ];
        }

        if ($this->linkExists((array)$resourceData, $id)) {
            return $this->connectToAPI('GET', $resource . '/' . $id);
        }

        return false;
    }

    protected function linkExists($data, $id) {
        foreach($data as $link) {
            if (explode('/', $link)[5] == $id) {
                return true;
            }
        }
        return false;
    }

    protected function cacheExists($url) {
        if (Cache::has($url)) {
            return Cache::get($url);
        }
        return false;
    }
}
