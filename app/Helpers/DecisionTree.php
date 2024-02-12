<?php

namespace App\Helpers;

use App\Models\Laptop;

class DecisionTree
{
    public $questionLength = 0;

    public $questions = [];

    public static function result(array $answers)
    {
        $options = self::getOptions($answers);

        $qBuilder = Laptop::query();

        foreach ($options as $option) {
            $symbol = $option[0];
            $columnName = $option[1];
            $value = $option[2];
            if ($symbol == '=') {
                $qBuilder->where($columnName, $value);
            } elseif ($symbol == '>=') {
                $qBuilder->where($columnName, '>=', $value);
            } elseif ($symbol == '<') {
                $qBuilder->where($columnName, '<', $value);
            } elseif ($symbol == 'in') {
                $qBuilder->whereIn($columnName, $value);
            }
        }

        return $qBuilder->orderby('ram', 'desc')->orderBy('price', 'asc')->get();
    }

    public static function getOptions(array $answers)
    {
        $questions = self::questions();
        $selectedQuestion = $questions[0];
        $options = [];
        foreach ($answers as $index => $value) {
            $option = $selectedQuestion['options'][$value];
            if ($option) {
                $options[] = $option;
            }

            if (! $selectedQuestion['children']) {
                break;
            }
            $selectedQuestion = $selectedQuestion['children'][$value];
            if (! $selectedQuestion) {
                break;
            }
        }

        return $options;
    }

    public static function questions()
    {

        $topBrands = [
            LaptopConstant::MANUFACTUR_TYPE_ACER,
            LaptopConstant::MANUFACTUR_TYPE_ASUS,
            LaptopConstant::MANUFACTUR_TYPE_DELL,
            LaptopConstant::MANUFACTUR_TYPE_HP,
            LaptopConstant::MANUFACTUR_TYPE_MSI,
            LaptopConstant::MANUFACTUR_TYPE_RAZER,
            LaptopConstant::MANUFACTUR_TYPE_TOSHIBA,
        ];
        $budget = 10000000;

        $prefPrice =
          self::createNode(
              'Apakah budget anda lebih dari 10jt ?',
              [
                  self::gte('price', $budget),
                  self::lt('price', $budget),
              ],
              [
                  self::createNode(
                      'Apakah butuh RAM lebih dari 8 GB ?',
                      [
                          self::gte('ram', 8),
                          self::lt('ram', 8),
                      ]
                  ),
                  self::createNode(
                      'Apakah butuh RAM lebih dari 8 GB ?',
                      [
                          self::gte('ram', 8),
                          self::lt('ram', 8),
                      ]
                  ),
              ],
          );

        return [
            self::createNode(
                'Apakah kamu perlu laptop yang dapat terintegrasi dengan baik pada perangkat lain ?',
                [
                    self::equalsWith('manufacturer', LaptopConstant::MANUFACTUR_TYPE_APPLE),
                    null,
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
                            null,
                        ],
                        [
                            $prefPrice,
                            $prefPrice,
                        ],
                    ),
                ]
            ),
        ];
    }

    /**
     * @param  string  $question  Pertanyaan yang akan ditampilkan ke user
     * @param  array  $options  [0] untuk jawaban Ya, dan [1] untuk jawaban tidak
     * @param  array  $childs  [0] untuk jawaban Ya, dan [1] untuk jawaban tidak, jika null berarti sudah selesai
     * @return array
     */
    public static function createNode(string $question, ?array $options = null, ?array $childs = null)
    {
        $obj = [
            'question' => $question,
            'options' => $options,
            'children' => $childs,
        ];

        return $obj;
    }

    /**
     * Equal with declare value
     */
    public static function equalsWith(string $columnName, $sameWith)
    {
        if (gettype($sameWith) == 'array') {
            return ['in', $columnName, $sameWith];
        }

        return ['=', $columnName, $sameWith];
    }

    /**
     * Greather tahn
     */
    public static function gte(string $columnName, $sameWith)
    {
        return ['>=', $columnName, $sameWith];
    }

    /**
     * Less Than
     */
    public static function lt(string $columnName, $sameWith)
    {
        return ['<', $columnName, $sameWith];
    }
}
