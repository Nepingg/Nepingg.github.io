<?php
namespace App\Encoder;

class CsvEncoder implements EncoderInterface {
    private function getDelimiter(string $format): string {
        return match($format) {
            'CSV' => ',',
            'SSV' => ';',
            'TSV' => "\t",
            default => ','
        };
    }

    public function supports(string $format): bool {
        return in_array($format, ['CSV', 'SSV', 'TSV']);
    }

    public function decode(string $data, string $format): array {
        //dekodowanie tekstu do tablicy  CSV/SSV/TSV
        $delimiter = $this->getDelimiter($format);
        $lines = explode("\n", trim($data));

        if (empty($lines[0])) return [];

        $headers = str_getcsv(array_shift($lines), $delimiter, '"', '');
        $result = [];

        foreach ($lines as $line) {
            if (trim($line) === '') continue;

            $values = str_getcsv($line, $delimiter, '"', '');

            if (count($headers) === count($values)) {
                $result[] = array_combine($headers, $values);
            }
        }
        return $result;
    }

    public function encode(array $data, string $format): string {
        // kodowanie tablicy do tekstu o zadanym formacie CSV/SSV/TSV
        if (empty($data)) return '';

        $delimiter = $this->getDelimiter($format);
        $headers = array_keys($data[0]);
        $output = implode($delimiter, $headers) . "\n";

        foreach ($data as $row) {
            $output .= implode($delimiter, array_values($row)) . "\n";
        }

        return trim($output);
    }
}