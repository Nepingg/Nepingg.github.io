<?php

require_once __DIR__.'/autoload.php';

use App\Encoder\CsvEncoder;
use App\Encoder\JsonEncoder;
use App\Encoder\YamlEncoder;
use App\Serializer;

$encoders = [
    new CsvEncoder(),
    new JsonEncoder(),
    new YamlEncoder()
];
$serializer = new Serializer($encoders);

$inputData = $_COOKIE['inputData'] ?? '';
$inputFormat = $_COOKIE['inputFormat'] ?? 'TSV';
$outputFormat = $_COOKIE['outputFormat'] ?? 'JSON';
$outputData = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $inputData = $_POST['inputData'] ?? '';
    $inputFormat = $_POST['inputFormat'] ?? 'TSV';
    $outputFormat = $_POST['outputFormat'] ?? 'JSON';

    setcookie('inputData', $inputData, time() + (86400 * 30), "/");
    setcookie('inputFormat', $inputFormat, time() + (86400 * 30), "/");
    setcookie('outputFormat', $outputFormat, time() + (86400 * 30), "/");

    if (!empty($inputData)) {
        try {
            $arrayData = $serializer->deserialize($inputData, $inputFormat);
            $outputData = $serializer->serialize($arrayData, $outputFormat);
        } catch (\Exception $e) {
            $outputData = "Wystąpił błąd: " . $e->getMessage();
        }
    }
}

require_once __DIR__.'/templates/layout.php';