<?php

namespace App\Services\Aws;

use App\Configs\Aws\AwsSqsConfig;
use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;

class AwsSqsService
{
    private SqsClient $client;

    public function __construct(AwsSqsConfig $awsSqsConfig) {
        $this->client = $awsSqsConfig->getClient();
    }

    public function sendMessage(string $queueUrl, string $messageBody): void
    {
        $params = [
            'QueueUrl' => $queueUrl,
            'MessageBody' => $messageBody,
        ];

        try {
            $this->client->sendMessage($params);
        } catch (AwsException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
