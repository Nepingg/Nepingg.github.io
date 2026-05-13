<?php
namespace App;

use App\Encoder\EncoderInterface;

class Serializer {
    /** @var EncoderInterface[] */
    private array $encoders;

    public function __construct(array $encoders) {
        $this->encoders = $encoders;
    }

    public function deserialize(string $data, string $format): array {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supports($format)) {
                return $encoder->decode($data, $format);
            }
        }
        throw new \Exception("Brak wsparcia dla formatu wejściowego: $format");
    }

    public function serialize(array $data, string $format): string {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supports($format)) {
                return $encoder->encode($data, $format);
            }
        }
        throw new \Exception("Brak wsparcia dla formatu wyjściowego: $format");
    }
}