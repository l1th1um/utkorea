<h1 style="text-align: center;">Data Mahasiswa UT Korea Tahun Ajaran <?php echo get_settings('time_period'); ?></h1>

<div style="width:100%;">
        <?php
            $i = 1;
            $grand_total_utara = 0;
            $grand_total_selatan = 0;
            foreach ($data as $key => $row) {
        ?>
                <div style='width:50%;float:left;padding-top:60px'>
                    <strong>Jurusan : <?php echo $row['major']?></strong>
                    <table style="width:90%">
                        <thead>
                             <tr>
                                <th style="width:50px;vertical-align: middle;" rowspan="2">No</th>
                                <th style="width:150px;vertical-align: middle;" rowspan="2">Semester</th>
                                <th colspan="2" style="text-align: right;">Jumlah Mahasiswa</th>
                                <th rowspan="2" style="vertical-align: middle;text-align: right;" >Sub Total</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">Utara</th>
                                <th style="text-align: right;">Selatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $j = 1;
                                $total = 0;
                                foreach ($row['details'] as $value) {
                                    $subtotal = $value['total_utara'] + $value['total_selatan'];
                                    $semester = calculate_semester($value['entry']);
                                    $url = 'kemahasiswaan/data/'.$key."/".$value['entry']."/";
                            ?>
                                    <tr>
                                        <td><?php echo $j;?></td>
                                        <td>Semester <?php echo numberToRoman($semester);?></td>
                                        <td style="text-align: right;"><?php echo anchor($url."1",$value['total_utara']);?></td>
                                        <td style="text-align: right;"><?php echo anchor($url."2",$value['total_selatan']);?></td>
                                        <td style="text-align: right;"><?php echo $subtotal;?></td>
                                    </tr>
                                <?php
                                    $grand_total_utara =  $grand_total_utara + $value['total_utara'];
                                    $grand_total_selatan =  $grand_total_selatan + $value['total_selatan'];
                                    
                                    $total = $total + $subtotal;
                                    $j++;
                                } 
                            ?>
                            <tr>
                                <td colspan="4" style="text-align: center;"><strong>Total</strong></td>
                                <td><strong><?php echo $total?></strong></td>
                            </tr>
                        </tbody>
                   </table>     
                </div>
        <?php
                $i++;
                
                if ($i % 2 != 0) {
                    echo "<div style='clear:both'></div>";
                }
            }
            
            
        ?>        
    <div style='clear:both'></div>
</div>

<div  style="padding-top: 50px;">
    <table>
        <tr>
            <td>Total Mahasiswa Di Utara</td>
            <td><?php echo $grand_total_utara?></td>
        </tr>
        <tr>
            <td>Total Mahasiswa Di Selatan</td>
            <td><?php echo $grand_total_selatan?></td>
        </tr>
        <tr>
            <td>Total Seluruh Mahasiswa</td>
            <td><?php echo $grand_total_utara + $grand_total_selatan; ?></td>
        </tr>
    </table>
</div>