<?php

	$path = dirname(__FILE__);
    $template = file_get_contents($path . '/template.html');

	setlocale(LC_MONETARY, 'en_US');

	$lastMonthTimestamp = strtotime("last month");
	$startDate = date('m/01/Y', $lastMonthTimestamp);
	$endDate = date('m/'. date('t', $lastMonthTimestamp ). '/Y', $lastMonthTimestamp);
	$workHours = $argv[1] ?? 160;
	$unitPrice = $argv[2] ?? 00;
	$total = $workHours * $unitPrice;

    $vars = [
        '$startDate' => $startDate,
        '$endDate' => $endDate,
        '$workHours' => $workHours,
        '$unitPrice' => money_format('%(#10n', $unitPrice) . "\n",
        '$total' => money_format('%(#10n', $total) . "\n",
    ];

    $fileName = $path .'/'.  date("m", $lastMonthTimestamp) .' - '. date('F', $lastMonthTimestamp) ;
    $newInvoiceHTML = file_put_contents($fileName.'.html', strtr($template, $vars));

    $toExecute = "wkhtmltopdf --page-size A7 '{$fileName}.html' '{$fileName}.pdf' ";
    print_r($toExecute . "\n");
    exec($toExecute);

