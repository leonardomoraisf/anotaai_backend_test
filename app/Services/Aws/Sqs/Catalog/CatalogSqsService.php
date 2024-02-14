<?php

namespace App\Services\Aws\Sqs\Catalog;

use App\Services\Aws\Sqs\AwsSqsService;

class CatalogSqsService extends AwsSqsService
{
    /**
     * @throws \JsonException
     */
    public function sendCatalogEmitProductMessage($product): void
    {
        $this->sendCatalogEmitMessage([
            'userId' => auth()->id(),
            'product' => $product,
            'type' => 'product',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function sendCatalogEmitCategoryMessage($category): void
    {
        $this->sendCatalogEmitMessage([
            'userId' => auth()->id(),
            'category' => $category,
            'type' => 'category',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function sendCatalogEmitMessage(array $messageBody): void
    {
        $this->sendMessage('catalog-emit', json_encode($messageBody, JSON_THROW_ON_ERROR));
    }
}
