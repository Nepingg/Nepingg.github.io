<?php
namespace App\Encoder;

class JsonEncoder implements EncoderInterface {
    public function supports(string $format): bool {
        return $format === 'JSON';
    }

    public function decode(string $data, string $format): array {
        //dekodowanie postaci tekstowej do tablicy JSON
        return json_decode($data, true) ?? [];
    }

    public function encode(array $data, string $format): string {
        //kodowanie tablicy do postaci tekstu JSON
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}