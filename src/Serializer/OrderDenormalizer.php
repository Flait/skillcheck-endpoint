<?php
namespace App\Serializer;

use App\Entity\Order;
use App\Entity\Product;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

final class OrderDenormalizer implements DenormalizerInterface
{
    /**
     * @param mixed[] $context
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        if (!is_array($data)) {
            throw new UnexpectedValueException('The data should be an array.');
        }

        $products = array_map(function ($productData) {
            return new Product(
                $productData['id'],
                $productData['name'],
                $productData['price']
            );
        }, $data['products']);

        return new Order(
            $data['id'],
            new \DateTimeImmutable($data['createdAt']),
            $data['name'],
            $data['amount'],
            $data['currency'],
            $data['status'],
            $products
        );
    }

    /**
     * @param mixed[] $context
     */
    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return $type === Order::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Order::class => true,
        ];
    }
}