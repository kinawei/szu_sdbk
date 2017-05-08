<?php
    include_once '../libs/phpQuery/phpQuery.php';
 header("Content-Type: application/json; charset=utf-8");

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://www.szu.edu.cn/board/");
    if (isset($_GET["today"]))
    {
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "dayy=1%23%D2%BB%CC%EC&search_type=title&keyword=&keyword_user=&searchb1=%CB%D1%CB%F7");
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $orgi = curl_exec($curl);
    curl_close($curl);

    //$orgi = file_get_contents("http://www.szu.edu.cn/board/");
    $orgi = iconv("GBK", "UTF-8//IGNORE", $orgi);
    $orgi = str_replace("&nbsp;", " ", $orgi);
    $orgi = str_replace("　", " ", $orgi);
    $orgi = strtr($orgi, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES)));
    $orgi = str_remove($orgi, '<meta http-equiv="Content-Type" content="text/html; charset=gb2312">');

    $data = phpQuery::newDocument($orgi)["body > table > tr:nth-child(2) > td > table > tr:nth-child(3) > td > table > tr:nth-child(3) > td > table"];
    /* $data->elements[0]->childNodes[$i]: one row of data (start from 2)
                                         ->childNodes[0]: id
                                         ->childNodes[2]: catagory
                                         ->childNodes[4]: author(inside an <a> tag)
                                         ->childNodes[6]: title area
                                         ->childNodes[8]: attachment
                                         ->childNodes[10]: date
    */

    $count = $data->elements[0]->childNodes->length;

    echo '[';
    for ($i = 2; $i < $count; $i++)
    {
        $item = $data->elements[0]->childNodes[$i];
        $catagory = $item->childNodes[2]->childNodes[0]->textContent;
        // $author = $item->childNodes[4]->childNodes[0]->textContent;

        $titleArea = $item->childNodes[6];
        $targetIndex = 1;
        $top = false;

        if ($titleArea->childNodes->length > 2)
        {
            $targetIndex = 2;
            $top = true;
        }

        $titleWrapper = pq($item->childNodes[6]->childNodes[$targetIndex]);
        // $title = substr($titleWrapper->text(), 2);
        $id = $titleWrapper->attr("href");
        $id = substr($id, strpos($id, "id=") + 3);

        // $date = $item->childNodes[10]->textContent;

        echo '{';
        echo '"id":' . $id . ',';
        echo '"catagory":"' . htmlspecialchars($catagory) . '",';
        // echo '"title":"' . htmlspecialchars($title) . '",';
        // echo '"author":"' . htmlspecialchars($author) . '",';
        // echo '"date":"' . $date . '",';
        echo '"top":' . ($top == true ? "true" : "false");
        echo '}';

        if ($i != $count - 1) echo ',';
    }
    echo ']';

    function array_exclude($array, $keys)
    {
        if (gettype($keys) != "array")
            $keys = array($keys);

        $newarray = $array;
        $arr_keys = array_keys($newarray);
        for ($i = 0; $i < count($newarray); $i++)
        {
            for ($j = 0; $j < count($keys); $j++)
            {
                if ($arr_keys[$i] == $keys[$j])
                {
                    array_splice($newarray, $i, 1);
                    array_splice($arr_keys, $i, 1);
                    $i--;
                    break;
                }
            }
        }

        return $newarray;
    }
    
    function array_element_settype(&$array, $i, $type)
    {
        if (isset($array[$i]))
            settype($array[$i], $type);
    }

    // convert every array element into query accaptable string
    function query_strings($array, $noquote = array())
    {
        global $_DATABASE;
        $newarray = $array;
        $keys = array_keys($newarray);

        for ($i = 0; $i < count($newarray); $i++)
        {
            if (is_null($newarray[$keys[$i]]))
                $newarray[$keys[$i]] = "null";
            else if (!(isset($noquote[$keys[$i]]) && $noquote[$keys[$i]]))
                $newarray[$keys[$i]] = "'" . $_DATABASE->real_escape_string($newarray[$keys[$i]]) . "'";
        }

        return $newarray;
    }

    function join_assoc_array($array, $split = ",")
    {
        $result = "";

        if (isset($array))
        {
            $keys = array_keys($array);

            for ($i = 0; $i < count($array); $i++)
            {
                $result .= $keys[$i] . "=" . $array[$keys[$i]];

                if ($i != count($array) - 1)
                    $result .= $split;
            }
        }

        return $result;
    }
    
    function relativePath($where)
    {
        return "http://".$_SERVER["HTTP_HOST"].$where;
    }

    function str_remove($from, $where)
    {
        return str_replace($where, "", $from);
    }
?>