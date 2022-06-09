
<div id="print">
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        td {
            padding: 5px;
        }
    </style>

    <?php
    $total = count($this->uri->segment_array());
    if ($total == 5) {
        $cat = $this->uri->segment(3);
        $sdate = $this->uri->segment(4);
        $edate = $this->uri->segment(5);
        $sdate1 = date("Y-m-d", strtotime($sdate));
        $edate2 = date("Y-m-d", strtotime($edate));

        $this->db->select("(SELECT SUM(amount) FROM payment WHERE income_category_id= '$cat' and idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'income') AS total_income", FALSE);
        $query = $this->db->get('payment')->result_array();
    } else {
        $sdate = $this->uri->segment(3);
        $edate = $this->uri->segment(4);
        $sdate1 = date("Y-m-d", strtotime($sdate));
        $edate2 = date("Y-m-d", strtotime($edate));
        $this->db->select("(SELECT SUM(amount) FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'income') AS total_income", FALSE);
        $query = $this->db->get('payment')->result_array();
    }
    $total = $query[0]['total_income'];
    ?>
    <table border="1" style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;">
        <thead>
            <tr>
                Total Income : <?php echo $total; ?>
                <th><div>#</div></th>
                <th><div><?php echo get_phrase('title'); ?></div></th>
                <th><div><?php echo get_phrase('category'); ?></div></th>
                <th><div><?php echo get_phrase('method'); ?></div></th>
                <th><div><?php echo get_phrase('amount'); ?></div></th>
                <th><div><?php echo get_phrase('date'); ?></div></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $count = 1;
            $total = count($this->uri->segment_array());
            if ($total == 5) {
                $cat = $this->uri->segment(3);
                $sdate = $this->uri->segment(4);
                $edate = $this->uri->segment(5);
                $sdate1 = date("Y-m-d", strtotime($sdate));
                $edate2 = date("Y-m-d", strtotime($edate));

                $sql = "SELECT * FROM payment WHERE income_category_id= '$cat' and idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'income'";
            } else {
                $sdate = $this->uri->segment(3);
                $edate = $this->uri->segment(4);
                $sdate1 = date("Y-m-d", strtotime($sdate));
                $edate2 = date("Y-m-d", strtotime($edate));
                $sql = "SELECT * FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'income'";
            }
            $incomes = $this->db->query($sql)->result_array();
            foreach ($incomes as $row):
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td>
                        <?php
                        if ($row['income_category_id'] != 0 || $row['income_category_id'] != '')
                            echo $this->db->get_where('income_category', array('income_category_id' => $row['income_category_id']))->row()->name;
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($row['method'] == 1)
                            echo get_phrase('cash');
                        if ($row['method'] == 2)
                            echo get_phrase('check');
                        if ($row['method'] == 3)
                            echo get_phrase('card');
                        ?>
                    </td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row['idate'])); ?></td>
                </tr>
            <?php endforeach; ?>
            </tr>

        </tbody>
    </table>
</div>



<script type="text/javascript">

    jQuery(document).ready(function ($)
    {
        var elem = $('#print');
        PrintElem(elem);
        Popup(data);

    });

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>