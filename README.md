# infortrend_ds_supinfo_ssd_smart

Utility for parsing a diagnostic file with information about used SSDs from the file supportinfo_XXXXXXX.zip and displaying their basic SMART attributes 

## To use it, you need the following:

- create and download archive of diagnostic information (using SANWatch/RaidWatch command *System -> Export System Information*)
- open archive and extract file NNNNN_ssd_NNNNNN-NNNNN.txt (N - numbers)
- run script supinfo_decoder.php in console, passing this text file througth pipe to STDIN.

You need installed console PHP in 64-bit environment. Utility was developed for showing data of SSD Micron 5300 MAX and Kingston SEDC500M, for other models it will be need to add their smart attributes in source code, which can be easily done.

## Example of usage:

```
$ php supinfo_decoder.php < 774023_ssd_20250430-144600196\ \(example\).txt
Slot: 1
Model: Micron_5300_MTFDDAK1T9TDT
01h - Raw read errors: 0
09h - Power-On Hours: 32285
0Ch - Power Cycle Count: 31
BBh - Unc. read errors: 0
C2h - Temperature: 24/15/33
C7h - UDMA errors count: 0
CAh - Life remaining: 100
F6h - Flash TB written: 1.2398558692075

Slot: 2
Model: Micron_5300_MTFDDAK1T9TDT
01h - Raw read errors: 0
09h - Power-On Hours: 32219
0Ch - Power Cycle Count: 36
BBh - Unc. read errors: 0
C2h - Temperature: 24/15/34
C7h - UDMA errors count: 0
CAh - Life remaining: 100
F6h - Flash TB written: 0.69590401090682

Slot: 3
Model: KINGSTON SEDC500M1920G
01h - Raw read errors: 0
09h - Power-On Hours: 32220
0Ch - Power Cycle Count: 21
BBh - Unc. read errors: 0
C2h - Temperature: 26/18/36
C7h - UDMA errors count: 0
E7h - Life remaining: 99
E9h - Flash TB written: 72.890625
```
