<?php //I:\ptw\nowe\Nepingg.github.io\lab-f/yaml.php


$data = [

    'name' => 'Misiukiewicz Michal',

    'index' => '57878',

    'date' => date(DATE_ATOM),

];


$yaml = yaml_emit($data);


echo $yaml;