<?php

namespace App\Configs\Aws;

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

class AwsSqsConfig
{
    public function getClient(): SqsClient
    {
        $config = [
            'region' => config('aws.region'),
            'version' => config('aws.version'),
            'credentials' => [
                'key' => config('aws.credentials.key'),
                'secret' => config('aws.credentials.secret'),
            ],
        ];

        try {
            $client = new SqsClient($config);
        } catch (AwsException $e) {
            throw new \RuntimeException($e->getMessage());
        }

        return $client;
    }
}
