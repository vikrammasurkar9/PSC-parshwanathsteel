<html>
    <style>
        table, td, th {
        border: 1px solid black;
        }

        table {
        border-collapse: collapse;
        width: 100%;
        }

        th, td {
        text-align:left;
        height:30px;
        }
    </style>
<?php
date_default_timezone_set('Asia/Kolkata');
//echo date('d-m-Y H:i');
$now = date('d-m-Y H:i:s');
    header('Content-type: application/excel');
    $filename = $name.'-'.$now. '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);
    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Sheet 1</x:Name>
                        <x:WorksheetOptions>
                            <x:Print>
                                <x:ValidPrinterInfo/>
                            </x:Print>
                        </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                </x:ExcelWorksheets>
            </x:ExcelWorkbook>
        </xml>
        <![endif]-->
    </head>';
?>
<body>
<div style="width:100%; text-align:center;">
        <h3 style="color:brown;">PARSHWANATH ISPAT PVT LTD</h3>         
        <!-- 120/1, P.B ROAD NH-4, NEAR MAHADIK PETROL PUMP SHIROLI (PULACHI)<br />
        Email - purchase@parshwanathsteel.com<br/>
        Tel - (0230) 2461285, 246009 Mob - 9960615933, 9823115933<br/>
        <b>GSTIN - 27AAFCP4825L1Z2</b><br/> -->
        <b><?= $name ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>Date : <?= date("d/m/Y", strtotime($now)); ?></b>
</div>
<div style="width:100%">
        
</div>
<br />
    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th rowspan=2>Sr.No</th>
                                <th rowspan=2>Product</th>
                                <th rowspan=2>Size</th>
                                <?php
                                    foreach ($brandsTable as $row) {
                                        echo "<th colspan=2 style='text-align:center;'>" . $row->name . "</th>";
                                    }    
                                ?>
                            </tr>
                            <tr>
                                    <?php
                                    foreach ($brandsTable as $row) {
                                        echo "<th>Rate + GST</th>";
                                        echo "<th>Rate including GST</th>";
                                    }    
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($result as $row) {
                                ?>
                            <tr>
                                <td><?php echo $count; ?></td>                                
                                <td><?php echo $row->product; ?></td>
                                <td><?php echo $row->sizeinmm; ?></td>
                                <?php                                    
                                    foreach ($brandsTable as $brand) {
                                        $found = false;
                                        foreach ($brandproducts as $brandproduct) {
                                            if($brand->id == $brandproduct->bid && $row->id == $brandproduct->pwid){
                                                $billingrate = $brandproduct->billingrate;
                                                $billingrateplusgst = $brandproduct->billingrate + ($brandproduct->billingrate * 18/100);
                                                if($billingrate > 0)
                                                {
                                                    echo "<td>" . number_format($billingrate, 1) . "</td>";
                                                    echo "<td>" . number_format($billingrateplusgst, 1) . "</td>";
                                                }
                                                else{
                                                    // echo "<td></td>";
                                                    // echo "<td></td>";
                                                }
                                                $found = true;
                                                break;
                                            }
                                        }
                                        if($found == false)
                                        {
                                            //echo "<td></td>";
                                        }
                                    }    
                                ?>
                            </tr>
                            <?php ++$count;
                                }?>
                        </tbody>
                    </table>

                    </body>
                    </html>
<?php
    echo $data;
?>