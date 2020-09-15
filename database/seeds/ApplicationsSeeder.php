<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        //Se recomienda crear key y token mediante Hash::make(Str::random(60))
        $application = Application::create([
            'name' => 'Developing',
            'domain_url' => 'localhost',
        ]);

        $application->token()->save([
            'key' => 'LjUvofc7fdrTxaojlV5WZKFbA5HXzmGQNmxohKECvr25Zqp91VSRARANGELS',
            'api_token' => 'LjUvofc7fdrTxaojlV5WZKFbRARANGELSA5HXzmGQNmxohKECvr25Zqp91VS',
        ]);
    }
}