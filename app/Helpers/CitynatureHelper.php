<?php namespace App\Helpers;


class CitynatureHelper {

    public static function getCatalogArrayFromCsvFile($csv_file)
    {
        $csv = file_get_contents( $csv_file);

        $csv_rows = explode("\n", $csv);

        $csv_rows = array_slice($csv_rows, 1, -1);

        $catalog = [];

        foreach ($csv_rows as $csv_row) {
            $cols = explode(";", $csv_row);

            if (substr($cols[0], 0, 3) != '00-') {
                continue;
            }

            $item = new \stdClass();

            $item->index   = trim($cols[0]);
            $item->article = trim($cols[1]);
            $item->title   = trim($cols[3]);
            $item->volume  = trim($cols[4]);
            $item->price_1 = trim($cols[6]);
            $item->price_2 = trim($cols[7]);
            $item->price_3 = trim($cols[8]);
            $item->price_4 = trim($cols[9]);

            $catalog[] = $item;

        }

        return $catalog;
    }

}