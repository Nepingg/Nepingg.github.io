<?php
namespace App\Encoder;

class YamlEncoder implements EncoderInterface {
    public function supports(string $format): bool {
        return $format === 'YAML';
    }

    public function decode(string $data, string $format): array {
        //dekodowanie tekstu do  tablicy w programie YAML
        return yaml_parse($data) ?: [];
    }

    public function encode(array $data, string $format): string {
        //kodowanie tablicy do tekstu  YAML
        return yaml_emit($data);
    }
}