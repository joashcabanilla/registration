<?php
    error_reporting(0);
    require_once(app_path('Includes/excel/spreadsheet/Writer.php'));

    function convertEncoding($string) {
        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $string);
    }
    
    $xls = new Spreadsheet_Excel_Writer();
    $header = $xls->addFormat(array('Size' => 11));
    $header->setLocked();
    $header->setBold();
    $header->setFontFamily('Arial');
    $header->setAlign("center");
    $header->setAlign("vcenter");

    $subheader = $xls->addFormat(array('Size' => 10));
    $subheader->setLocked();
    $subheader->setFontFamily('Arial');
    $subheader->setAlign("center");
    $subheader->setAlign("vcenter");
 
    $subheaderB = $xls->addFormat(array('Size' => 11));
    $subheaderB->setLocked();
    $subheaderB->setFontFamily('Arial');
    $subheaderB->setAlign("center");
    $subheaderB->setAlign("vcenter");
    $subheaderB->setBold();
    $subheaderB->setBorder(1);
    $subheaderB->setFgColor('yellow');

    $subheaderNB = $xls->addFormat(array('Size' => 11));
    $subheaderNB->setLocked();
    $subheaderNB->setFontFamily('Arial');
    $subheaderNB->setAlign("left");
    $subheaderNB->setAlign("vcenter");
    $subheaderNB->setBold();

    $subheaderName = $xls->addFormat(array('Size' => 10));
    $subheaderName->setLocked();
    $subheaderName->setFontFamily('Arial');
    $subheaderName->setAlign("left");
    $subheaderName->setAlign("vcenter");
    $subheaderName->setBold();

    $normal = $xls->addFormat(array('Size' => 10));
    $normal->setFontFamily('Arial');
    $normal->setAlign("left");
    $normal->setAlign("vcenter");
    $normal->setTextWrap();
    $normal->setLocked();
    $normal->setBorder(1);
    
    $normalC = $xls->addFormat(array('Size' => 10));
    $normalC->setFontFamily('Arial');
    $normalC->setAlign("center");
    $normalC->setAlign("vcenter");
    $normalC->setTextWrap();
    $normalC->setLocked();
    $normalC->setBorder(1);

    $normalB = $xls->addFormat(array('Size' => 10));
    $normalB->setFontFamily('Arial');
    $normalB->setAlign("center");
    $normalB->setAlign("vcenter");
    $normalB->setTextWrap();
    $normalB->setLocked();
    $normalB->setBold();
    $normalB->setBorder(1);

    $normalR = $xls->addFormat(array('Size' => 10));
    $normalR->setFontFamily('Arial');
    $normalR->setAlign("right");
    $normalR->setAlign("vcenter");
    $normalR->setTextWrap();
    $normalR->setBold();
    $normalR->setLocked();
    $normalR->setBorder(1);

    $sheet = $xls->addWorksheet($title);
    $fields = array(
        array('MemId',15),
        array('PbNo',15),
        array('Name',30),
        array('Branch',20),
        array($category,20),
        array('Rice',15),
        array('Gift Check',15),
        array('T-shirt',15),
        array('Staff Name', 20),
        array('Date Received', 18)
    );

    if($category == "Share Capital"){
        unset($fields[7]);
    }else{
        unset($fields[0]);
        unset($fields[1]);
    }

    $c = $r = 0;
    foreach($fields as $fieldinfo):
        list($caption,$colwidth) = $fieldinfo;
        $sheet->setColumn($c,$c,$colwidth);
        $sheet->write($r,$c,$caption,$subheaderB);$c++;
    endforeach;
    $r++;
    
    foreach($giveawayList as $data){
        $c = 0;
        if($category == "Share Capital"){
            $sheet->writeString($r,$c,$data["memid"],$normalC);$c++;
            $sheet->writeString($r,$c,$data["pbno"],$normalC);$c++;
        }
        $sheet->writeString($r,$c,convertEncoding($data["name"]),$normal);$c++;
        $sheet->writeString($r,$c,$data["branch"],$normalC);$c++;
        $sheet->writeString($r,$c,$data[$category == "Share Capital" ? "sharecapital" : "timedeposit"],$normalC);$c++;
        $sheet->writeString($r,$c,$data["rice"],$normalC);$c++;
        $sheet->writeString($r,$c,$data["giftcheck"],$normalC);$c++;
        if($category == "Time Deposit"){
            $sheet->writeString($r,$c,$data["tshirt"],$normalC);$c++;
        }
        $sheet->writeString($r,$c,$data["updatedBy"],$normalC);$c++;
        $sheet->writeString($r,$c,$data["dataReceived"],$normalC);$c++;
        $r++;
    }   

    $r+=2;
    $c = 0;
    $header = $title == "Share Capital Giveaway" ? "Share Capital Giveaway Summary" : "Time Deposit Giveaway Summary";
    $sheet->writeString($r,$c,$header,$subheaderNB);
    $sheet->mergeCells($r,$c,$r,$category == "Share Capital" ? 2 : 3);
    $r++;
    $c = 0;
    $fields = array(
        array('Date Received', 15),
        array('Rice',15),
        array('Gift Check',15),
        array('T-shirt',15),
    );

    if($category == "Share Capital"){
        unset($fields[3]);
    }

    $r++;
    foreach($fields as $fieldinfo):
        list($caption,$colwidth) = $fieldinfo;
        $sheet->setColumn($c,$c,$colwidth);
        $sheet->write($r,$c,$caption,$subheaderB);$c++;
    endforeach;
    $r++;

    foreach($summaryList as $dateReceived => $summary){
        $c = 0;
        $sheet->writeString($r,$c,$dateReceived,$normalC);$c++;
        $sheet->writeString($r,$c,$summary["rice"]." KLS",$normalC);$c++;
        $sheet->writeString($r,$c,number_format($summary["giftcheck"], 0, '.', ','),$normalC);$c++;
        if($category == "Time Deposit"){
            $str = $summary["tshirt"] > 1 ? "pcs" : "pc";
            $sheet->writeString($r,$c,$summary["tshirt"]." ".$str,$normalC);$c++;
        }
        $r++;
    }
    
    $xls->send($title.".xls");
    $xls->close();
    die;
?>
    