<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class ReportHandlerComponent extends Component
{

    public function tocsv($data, $filename='students.csv')
    {
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=".$filename);
        header("Pragma: no-cache");
        header("Expires: 0");

        $result = "";
        if (count($data) > 0) {
            $keys = array_keys($data[0]);
            $first = true;
            foreach ($keys as $key) {
                if (!$first) {
                    $result .= ",";
                }
                $key = str_replace("}", "|", $key);
                $key = str_replace("{", "|", $key);
                $key = str_replace(",", "|", $key);
                $key = trim($key);
                $result .= $key;
                $first = false;
            }
            foreach ($data as $row) {
                $result .= "\n";
                $first = true;
                foreach ($row as $col) {
                    if (!$first) {
                        $result .= ",";
                    }
                    $col = str_replace("}", "|", $col);
                    $col = str_replace("{", "|", $col);
                    $col = str_replace(",", "|", $col);
                    $col = trim($col);
                    $result .= "{$col}";
                    $first = false;
                }
            }
        }
        echo $result;
    }

}