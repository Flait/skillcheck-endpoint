<?php


namespace App\Entity;

readonly class Product
{
    public function __construct(
        public int    $id,
        public string $name,
        public int    $price,
    )
    {
    }

    /**
     * @return array<string,int|string>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}