


<div class="row">    
    <div class="col-md-2"></div>
    <div class="col-md-8">

        <div id="attendance_update">
            <h3>
                <?php
                $this->db->select("(SELECT SUM(due) FROM invoice WHERE status= 'unpaid' and year= '$running_year') AS total_due", FALSE);
                $query = $this->db->get('invoice')->result_array();
                $total = $query[0]['total_due'];
                ?>
                Total Due : <b style="color: red;  " title="Total Expense :-)"><?php echo $total; ?></b> </h3>

            <br><br>
            <table class="table table-bordered datatable example">
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
                    $sql = "SELECT * FROM invoice WHERE status= 'unpaid' and year= '$running_year'";
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
            <a href="<?php echo base_url(); ?>index.php?admin/due_view" 
               class="btn btn-primary" target="_blank">
                <?php echo get_phrase('due_sheet'); ?>
            </a>

        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {


        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [

                    {
                        "sExtends": "xls",
                        "mColumns": [1, 2, 3, 4, 5]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1, 2, 3, 4, 5]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText": "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(0, false);
                            datatable.fnSetColumnVis(6, false);

                            this.fnPrint(true, oConfig);

                            window.print();

                            $(window).keyup(function (e) {
                                if (e.which == 27) {
                                    datatable.fnSetColumnVis(0, true);
                                    datatable.fnSetColumnVis(6, true);
                                }
                            });
                        },

                    },
                ]
            },

        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

</script>

