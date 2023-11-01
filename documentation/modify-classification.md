# Modifikasi klasifikasi

Untuk memodifikasi pertanyaan, dapat dilakukan dengan membuka file `app/Helpers/DecisionTree.php`. Daftar pertanyaan terdapat pada fungsi `questions`

contoh untuk memodifikasi

```php
  public static  function questions()
  {
    return [
      self::createNode(
        'Apakah kamu perlu laptop yang dapat terintegrasi dengan baik pada perangkat lain ?',
        [
          self::equalsWith('manufacturer', LaptopConstant::MANUFACTUR_TYPE_APPLE),
          null
        ],
        [
          /**
           * Untuk menambahkan pertanyaan silahkan buka doke yang di comment dan comment tipe data null
           */
          
          // self::createNode(
          //   'Apakah budget anda lebih dari 15 Jt ?',
          //   [
          //     self::gte('price', 15000000),
          //     self::lt('price', 15000000),
          //   ],
          // ),
          null,
          self::createNode(
            'Apakah anda peduli dengan brand ?',
            [
              self::equalsWith('manufacturer', $topBrands),
              null
            ]
          )
        ]
      ),
    ];
  }
```
