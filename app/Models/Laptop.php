<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer',
        'model_name',
        'category',
        'screen_size',
        'screen',
        'cpu',
        'ram',
        'storage',
        'gpu',
        'operating_system',
        'operating_system_version',
        'weight',
        'price',
    ];

    public static function existing(string $manufacturer, string $modelName, string $category, string $cpu, int $ram)
    {
        return self::where('manufacturer', $manufacturer)
            ->where('model_name', $modelName)
            ->where('category', $category)
            ->where('cpu', $cpu)
            ->where('ram', $ram)
            ->exists();
    }

    public static function insertNewData($item)
    {
        $itemWithSpecificKey = [
            'manufacturer' => $item[0],
            'model_name' => $item[1],
            'category' => $item[2],
            'screen_size' => floatval($item[3]),
            'screen' => $item[4],
            'cpu' => $item[5],
            'ram' => intval($item[6]),
            'storage' => $item[7],
            'gpu' => $item[8],
            'operating_system' => $item[9],
            'operating_system_version' => $item[10],
            'weight' => floatval($item[11]),
            'price' => self::convertEuroToIdr($item[12]),
        ];

        if (self::create($itemWithSpecificKey)) {
            return true;
        }

        return false;
    }

    private static function convertEuroToIdr($euro)
    {
        $kurs = 15500;

        return intval($euro) * $kurs;
    }

    public function getPriceIdrAttribute()
    {
        return 'Rp '.number_format($this->price ?? 0);
    }

    public function getWeightLabelAttribute()
    {
        return $this->weight.' KG';
    }

    public function getRamLabelAttribute()
    {
        return $this->ram.' GB';
    }

    public function setOperatingSystemVersionAttribute($value)
    {
        $this->attributes['operating_system_version'] = $value ?? '';
    }
}
