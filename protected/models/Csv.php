<?php

class Csv extends CModel {

    public function attributeNames()
    {

    }

    public function export($distributors)
    {

        $fp = fopen('/srv/sites/taursus.com/www/public/file.csv', 'w');
        foreach ($distributors as $d){
            $temp = array();
            foreach ($d as $key => $value){
                $temp[$key] = $value;
            }
            fputcsv($fp, $temp);
        }

        fclose($fp);
    }
}
?>