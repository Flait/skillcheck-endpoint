<?php

namespace App\Entity;

class Order
{
    public function __construct(
        readonly public int $id,
        private \DateTimeInterface $createdAt,
        private string $name,
        private int $amount,
        private string $currency,
        private string $status
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


}

