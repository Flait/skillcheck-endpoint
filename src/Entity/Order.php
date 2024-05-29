<?php

namespace App\Entity;

class Order
{
    /**
     * @param Product[] $products
     */
    public function __construct(
        readonly public int $id,
        private \DateTimeInterface $createdAt,
        private string $name,
        private int $amount,
        private string $currency,
        private string $status,
        private array $products,
    ) {
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt->format('c'), // ISO 8601 format
            'name' => $this->name,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'products' => array_map(function(Product $product) {
                return $product->toArray();
            }, $this->products),
        ];
    }
}

