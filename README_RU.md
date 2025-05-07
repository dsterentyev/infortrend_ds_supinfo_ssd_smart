# infortrend_ds_supinfo_ssd_smart

Утилита для парсинга диагностического файла СХД Infortrend DS с информацией об используемых SSD из файла supportinfo_XXXXXXX.zip и отображения их основных SMART-аттрибутов

## Для её использования требуется:

- сформировать и скачать архив диагностической информации (с помощью команды SANWatch *System -> Export System Information*)
- открыть архив и извлечь файл NNNNN_ssd_NNNNNN-NNNNN.txt (N - цифры)
- запустить в консоли скрипт supinfo_decoder.php, передав ему текстовый файл через STDIN .

Для работы нужен установленный php и 64-битное окружение. Утилита разрабатывалась для получения данных с SSD Micron 5300 и Kingston SEDC500M, для других моделей понадобится описать их smart-аттрибуты в исходном коде (что может быть легко сделано).

## Пример использования:

```
$ php supinfo_decoder.php < 774023_ssd_20250430-144600196\ \(example\).txt
Slot: 1
Model: Micron_5300_MTFDDAK1T9TDT               
01h - Raw read errors:   0
09h - Power-On Hours:    32285
0Ch - Power Cycle Count: 31
BBh - Unc. read errors:  0
C2h - Temperature:       24/15/33
C7h - UDMA errors count: 0
CAh - Life remaining:    100
F6h - Flash TB written:  1.2398558692075

Slot: 2
Model: Micron_5300_MTFDDAK1T9TDT               
01h - Raw read errors:   0
09h - Power-On Hours:    32219
0Ch - Power Cycle Count: 36
BBh - Unc. read errors:  0
C2h - Temperature:       24/15/34
C7h - UDMA errors count: 0
CAh - Life remaining:    100
F6h - Flash TB written:  0.69590401090682

Slot: 3
Model: KINGSTON SEDC500M1920G                  
01h - Raw read errors:   0
09h - Power-On Hours:    32220
0Ch - Power Cycle Count: 21
BBh - Unc. read errors:  0
C2h - Temperature:       26/18/36
C7h - UDMA errors count: 0
E7h - Life remaining:    99
E9h - Flash TB written:  72.890625
```


