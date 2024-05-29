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
}