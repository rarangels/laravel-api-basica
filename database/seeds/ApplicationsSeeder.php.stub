<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Rarangels\ApiBasica\Models\Application;

class ApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Application::create([
            'name' => 'Developing',
            'domain_url' => 'localhost',
            'key' => Str::random(60),
            'api_token' => 'LjUvofc7fdrTxaojlV5WZKFbRARANGELSA5HXzmGQNmxohKECvr25Zqp91VS'
        ]);
    }
}