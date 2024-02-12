<?php

namespace Database\Seeders;

use App\Models\Laptop;
use Illuminate\Database\Seeder;

class LaptopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $results = [];
        if (! $this->read_csv(base_path('/public/laptops.csv'), $results)) {
            echo 'Cant open file';
        }

        foreach ($results as $index => $item) {
            if ($index == 0) {
                continue;
            }
            if (Laptop::existing($item[0], $item[1], $item[2], $item[5], intval($item[6]))) {
                continue;
            }

            if (! Laptop::insertNewData($item)) {
                dd($item);
            }
        }
    }

    /**
     * Reading a CSV file with fgetcsv
     *
     * @param  string  $path_to_csv_file  The path to the CSV file
     * @param  array  &$result  Stores the data in the reference variable.
     */
    public function read_csv(string $path_to_csv_file, array &$result, string $delimiter = ','): bool
    {
        $handle = fopen($path_to_csv_file, 'r');

        if (! $handle) {
            return false;
        }

        while (false !== ($data = fgetcsv($handle, null, $delimiter))) {
            $result[] = $data;
        }

        return true;
    }
}
