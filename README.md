# ZRXP Library to write ZRXP files

The data format ZRXP is a line-oriented text file format having ISO-8859-1 encoding which corresponds to ISO-LATIN-1. It allows to export various information about time series values (time stamp, the value itself; the status of
a value (encoded); the status as short text. the status as long text, influences, etc.). The related column definition is
contained in the block header.
A file in ZRXP format consists of one or several segments (blocks) with each segment being divided into a basic data
header and a time series value block

Reference: [ZRXP 3.0 Reference Manual](https://prozessing.tbbm.at/zrxp/zrxp3.0_de.pdf)

This library is a PHP implementation to write ZRXP files.

## Installation

```bash
composer require zahnentechnik/zrxp
```

## Usage

```php
<?php

// Set the keywords for the header of the file.
// A list of all keywords can be found in the Keywords Enum or in the Reference Manual
$keywords = [
    Keywords::SANR->value => "12345678",
    Keywords::SNAME->value => "Superstation",
    Keywords::SWATER->value => "River",
    ...
];

// Set the layout of the data
// A list of all layout attributes can be found in the LayoutAttributes Enum or in the Reference Manual
$layout = [
    LayoutAttributes::TIMESTAMP->value,
    LayoutAttributes::VALUE->value,
    LayoutAttributes::PRIMARY_STATUS->value,
];

// create the encoder
$encoder = new ZahnenTechnik\Zrxp\Encoder($keywords, $layout);

// data to be encoded, which of course can be read from a database or other source
$data = [
    [
        LayoutAttributes::TIMESTAMP->value => 20240803103000,
        LayoutAttributes::VALUE->value => 1.0,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::VALUE->value => 3.1,
        LayoutAttributes::TIMESTAMP->value => 20240803153000,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    ...
];
// encode the data
$fileContent = $encoder->encode($data);

// write the file or do whatever you want with the content
file_put_contents('output.zrxp', $fileContent);
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
```