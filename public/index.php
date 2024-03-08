<?php

/**
 * This example demonstrates how to use the Encoder class to encode data into a Zrxp file.
 */

require_once '../vendor/autoload.php';

use ZahnenTechnik\Zrxp\Keywords;
use ZahnenTechnik\Zrxp\LayoutAttributes;

$keywords = [
    Keywords::SANR->value => "12345678",
    Keywords::SNAME->value => "Superstation",
    Keywords::SWATER->value => "Prüm",
    Keywords::CDASA->value => 1123,
    Keywords::CDASANAME->value => "Test",
    Keywords::CCHANNEL->value => "Test",
    Keywords::CCHANNELNO->value => "Test",
    Keywords::CMW->value => 123,
    Keywords::CNAME->value => "Test",
    Keywords::CNR->value => "Test",
    Keywords::CUNIT->value => "m3/s",
    Keywords::REXCHANGE->value => "Test",
    Keywords::RINVAL->value => 12.1,
    Keywords::RTIMELVL->value => "Test",
    Keywords::XVLID->value => 121,
    Keywords::TSPATH->value => "Test",
    Keywords::CTAG->value => "Test",
    Keywords::CTAGKEY->value => "Test",
    Keywords::XTRUNCATE->value => true,
    Keywords::METCODE->value => "Test",
    Keywords::METERNUMBER->value => "Test",
    Keywords::EDIS->value => "Test",
    Keywords::TZ->value => "Test",
    Keywords::TASKID->value => "Test",
    Keywords::SOURCESYSTEM->value => "Test",
    Keywords::SOURCEID->value => "Test",
];

$layout = [
    LayoutAttributes::TIMESTAMP->value,
    LayoutAttributes::VALUE->value,
    LayoutAttributes::PRIMARY_STATUS->value,
];
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
    [
        LayoutAttributes::TIMESTAMP->value => 20240803110000,
        LayoutAttributes::VALUE->value => 1.3,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::PRIMARY_STATUS->value => 0,
        LayoutAttributes::TIMESTAMP->value => 20240803113000,
        LayoutAttributes::VALUE->value => 1.5,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803120000,
        LayoutAttributes::VALUE->value => 1.7,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803140000,
        LayoutAttributes::VALUE->value => 2.5,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803123000,
        LayoutAttributes::VALUE->value => 1.9,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
        ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803130000,
        LayoutAttributes::VALUE->value => 2.1,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803133000,
        LayoutAttributes::VALUE->value => 2.3,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803143000,
        LayoutAttributes::VALUE->value => 2.7,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803150000,
        LayoutAttributes::VALUE->value => 2.9,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803160000,
        LayoutAttributes::VALUE->value => 3.3,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803163000,
        LayoutAttributes::VALUE->value => 3.5,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803170000,
        LayoutAttributes::VALUE->value => 3.7,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803173000,
        LayoutAttributes::VALUE->value => 3.9,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],
    [
        LayoutAttributes::TIMESTAMP->value => 20240803180000,
        LayoutAttributes::VALUE->value => 4.1,
        LayoutAttributes::PRIMARY_STATUS->value => 255,
    ],
    [
        LayoutAttributes::TIMESTAMP->value =>20240803183000,
        LayoutAttributes::VALUE->value => 4.3,
        LayoutAttributes::PRIMARY_STATUS->value => 0,
    ],

];

$encoder = new ZahnenTechnik\Zrxp\Encoder($keywords, $layout);

$fileContent = $encoder->encode($data);

if ($encoder->getErrors()) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'errors' => $encoder->getErrors()
    ]);
} else {
    // set the header
    header('Content-Type: application/text');
    // set filename and force download
    header('Content-Disposition: attachment; filename="test.zrxp"');
    // output the encoded data
    echo $fileContent;
}