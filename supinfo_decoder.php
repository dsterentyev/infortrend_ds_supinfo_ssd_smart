#!/usr/bin/php
<?php

$f = fopen( 'php://stdin', 'r' );

$cnt = 0;
while( $line = fgets( $f ) ) {
	if(preg_match('/^Slot:\s+(\d+)/', $line, $m))
	{
		echo ($cnt++ > 0 ? "\n" : '') . "Slot: $m[1]\n";
		$slot = $m[1];
	}
	if(preg_match('/^\s*Model Detail:\s+(.+)/', $line, $m))
	{
		echo "Model: $m[1]\n";
		$model = $m[1];
	}
	if(preg_match('/^\s*SMART DATA:\s+(.+)/', $line, $m))
	{
		parse_smart($slot, $model, $m[1]); 
	}
}

fclose( $f );

function parse_smart($slot, $model, $data)
{
	for($cnt = 0; $cnt < 47; $cnt++)
	{
		//extract attribute
		$attr = substr($data, 4 + $cnt * 24, 24);
		//extract attribute number
		$anum = substr($attr, 0, 2);
		//extract attribute value
		$aval = substr($attr, 6, 2);
		//extract attribute values
		$araw2 = substr($attr, 12, 2) . substr($attr, 10, 2);
		$araw2_2 = substr($attr, 16, 2) . substr($attr, 14, 2);
		$araw2_3 = substr($attr, 20, 2) . substr($attr, 18, 2);
		$araw3 = substr($attr, 14, 2) . $araw2;
		$araw4 = substr($attr, 16, 2) . $araw3;
		$araw5 = substr($attr, 18, 2) . $araw4;
		$araw6 = substr($attr, 20, 2) . $araw4;
		//Micron SSDs - TN-FD-48: 5300 SSD SMART Implementation
		if(preg_match('/^Micron_/', $model) && in_array($anum, array('01', 'CA', '09', 'F6')))
		{
			//Raw Read Error Rate
			if($anum == '01')
			{
				echo("01h - Raw read errors:   " . hexdec($araw4) . "\n");
			}
			//life remaining attribute
			if($anum == 'CA')
			{
				echo("CAh - Life remaining:    " . hexdec($aval) . "\n");
			}
			//power-on hours attribute
			if($anum == '09')
			{
				echo("09h - Power-On Hours:    " . hexdec($araw3) . "\n");
			}
			//host written LBAs (conwerted to TBWs)
			if($anum == 'F6')
			{
				echo("F6h - Flash TB written:  " . (hexdec($araw6) * 512 / 1024 / 1024 / 1024 / 1024) . "\n");
			}
		}
		//Kingston SSDs - https://media.kingston.com/support/downloads/MKP_521_Phison_SMART_attribute.pdf
		else if(preg_match('/^KINGSTON /', $model) && in_array($anum, array('E7', 'E9')))
		{
			//life remaining attribute
			if($anum == 'E7')
			{
				echo("E7h - Life remaining:    " . hexdec($aval) . "\n");
			}
			//flash written GBs (conwerted to TBWs)
			if($anum == 'E9')
			{
				echo("E9h - Flash TB written:  " . hexdec($araw3) / 1024 . "\n");
			}
		}
		//generic attributes
		else
		{
			//Raw Read Error Rate
			if($anum == '01')
			{
				echo("01h - Raw read errors:   " . hexdec($araw2) . "\n");
			}
			//power-on hours attribute
			if($anum == '09')
			{
				echo("09h - Power-On Hours:    " . hexdec($araw2) . "\n");
			}
			//Power Cycle Count
			if($anum == '0C')
			{
				echo("0Ch - Power Cycle Count: " . hexdec($araw2) . "\n");
			}
			//Temperature
			if($anum == 'BB')
			{
				echo("BBh - Unc. read errors:  " . hexdec($araw4) . "\n");
			}
			//Temperature
			if($anum == 'C2')
			{
				echo("C2h - Temperature:       " . hexdec($araw2) . "/" . hexdec($araw2_2) . "/" . hexdec($araw2_3) . "\n");
			}
			//Ultra-DMA CRC Error Rate
			if($anum == 'C7')
			{
				echo("C7h - UDMA errors count: " . hexdec($araw4) . "\n");
			}
		}
	}
}

?>
