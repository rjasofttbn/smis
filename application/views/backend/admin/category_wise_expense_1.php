
<!-- <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/expense_add/');" 
class="btn btn-primary pull-right">
<i class="entypo-plus-circled"></i>



<?php echo get_phrase('add_new_expense'); ?>
</a> --> 
<?php echo form_open(base_url() . 'index.php?admin/category_expense/'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('category'); ?></label>
                    <div class="col-sm-3">
                        <select name="expense_category_id" class="form-control selectboxit" required>
                            <option value=""><?php echo get_phrase('select_expense_category'); ?></option>
                            <?php
                            $categories = $this->db->get('expense_category')->result_array();
                            foreach ($categories as $row):
                                ?>
                                <option value="<?php echo $row['expense_category_id']; ?>"><?php echo $row['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div><br><br>



                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase(' start date'); ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="datepicker form-control" name="start_date"
                               />
                    </div>
                </div><br><br>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo get_phrase('end date'); ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="datepicker form-control" name="end_date"
                               />
                    </div>
                </div><br><br>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <a href="<?php echo base_url(); ?>index.php?admin/category_expense" target="_blank">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('search'); ?></span>
                    </a>
                        <!--<button type="submit" class="btn btn-info"><?php echo get_phrase('search'); ?></button>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<hr>
<br><br>
<h3>
    <?php
    $this->db->select("(SELECT SUM(amount) FROM payment WHERE payment_type= 'expense' and year= '$running_year') AS total_expense", FALSE);
    $query = $this->db->get('payment')->result_array();
    $total = $query[0]['total_expense'];
    ?>
    Total Expense : <b style="color: red;  " title="Total Expense :-)"><?php echo $total; ?></b> </h3>
<table class="table table-bordered datatable" id="table_export">
    <thead>
        <tr>
             Present Session Total Expense : <?php echo $total; ?>
            <th><div>#</div></th>
            <th><div><?php echo get_phrase('title'); ?></div></th>
            <th><div><?php echo get_phrase('category'); ?></div></th>
            <th><div><?php echo get_phrase('method'); ?></div></th>
            <th><div><?php echo get_phrase('amount'); ?></div></th>
            <th><div><?php echo get_phrase('date'); ?></div></th>
            <!-- <th><div><?php echo get_phrase('options'); ?></div></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $this->db->where('payment_type', 'expense');
        $this->db->where('year', $running_year);
        $this->db->order_by('timestamp', 'desc');
        $expenses = $this->db->get('payment')->result_array();
        foreach ($expenses as $row):
            ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td>
                    <?php
                    if ($row['expense_category_id'] != 0 || $row['expense_category_id'] != '')
                        echo $this->db->get_where('expense_category', array('expense_category_id' => $row['expense_category_id']))->row()->name;
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
                <td><?php echo date('d M,Y', $row['timestamp']); ?></td>


                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



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

