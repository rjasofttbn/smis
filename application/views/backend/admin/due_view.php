
<div id="print">
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        td {
            padding: 5px;
        }
    </style>
    <h3>
        <?php
        $this->db->select("(SELECT SUM(due) FROM invoice WHERE status= 'unpaid') AS total_due", FALSE);
        $query = $this->db->get('invoice')->result_array();
        $total = $query[0]['total_due'];
        ?>
        Total Due : <b style="color: red;  " title="Total Due :-)"><?php echo $total; ?></b> </h3>

    <br><br>
    <table border="1" style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;">
        <thead>
            <tr>
                <th>#</th>
                <th><div><?php echo get_phrase('student'); ?></div></th>
                <th><div><?php echo get_phrase('title'); ?></div></th>
                <th><div><?php echo get_phrase('total'); ?></div></th>
                <th><div><?php echo get_phrase('unpaid'); ?></div></th>
                <th><div><?php echo get_phrase('status'); ?></div></th>
                <th><div><?php echo get_phrase('date'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sql = "SELECT * FROM invoice WHERE status= 'unpaid'";
            $invoices = $this->db->query($sql)->result_array();
            foreach ($invoices as $row):
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $this->crud_model->get_type_name_by_id('student', $row['student_id']); ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['due']; ?></td>
                    <?php if ($row['due'] == 0): ?>
                        <td>
                            <button class="btn btn-success btn-xs"><?php echo get_phrase('paid'); ?></button>
                        </td>
                    <?php endif; ?>
                    <?php if ($row['due'] > 0): ?>
                        <td>
                            <button class="btn btn-danger btn-xs"><?php echo get_phrase('unpaid'); ?></button>
                        </td>
                    <?php endif; ?>
                    <td><?php echo date('d M,Y', $row['creation_timestamp']); ?></td>
                </tr>
            <?php endforeach; ?>
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