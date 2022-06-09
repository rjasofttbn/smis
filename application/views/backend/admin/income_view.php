<hr />

<?php echo form_open(base_url() . 'index.php?admin/category_income/'); ?>
<div class="row">

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('category'); ?></label>
            <select name="income_category_id" class="form-control selectboxit" >
                <option value=""><?php echo get_phrase('select_income_category'); ?></option>
                <?php
                $categories = $this->db->get('income_category')->result_array();
                foreach ($categories as $row):
                    ?>
                    <option value="<?php echo $row['income_category_id']; ?>"><?php echo $row['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>


    <div id="section_holder">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('start date'); ?></label>
                <input type="text" class="form-control datepicker" name="start_date" data-format="dd-mm-yyyy"
                       value="<?php echo date("d-m-Y"); ?>"/>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('end date'); ?></label>
            <input type="text" class="form-control datepicker" name="end_date" data-format="dd-mm-yyyy"
                   value="<?php echo date("d-m-Y"); ?>"/>
        </div>
    </div>
    <input type="hidden" name="year" value="<?php echo $running_year; ?>">

    <div class="col-md-3" style="margin-top: 20px;">
        <button type="submit" class="btn btn-info"><?php echo get_phrase('search_income'); ?></button>
    </div>

</div>
<?php echo form_close(); ?>


<hr />

<br>

<div class="row">
    <!--<h3>-->
    <?php
    $total = count($this->uri->segment_array());
    if ($total == 5) {
        $cat = $this->uri->segment(3);
        $sdate = $this->uri->segment(4);
        $edate = $this->uri->segment(5);
        $sdate1 = date("Y-m-d", strtotime($sdate));
        $edate2 = date("Y-m-d", strtotime($edate));

//                        $sql = "SELECT * FROM payment WHERE expense_category_id= '$cat' and idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'expense'";

        $this->db->select("(SELECT SUM(amount) FROM payment WHERE income_category_id= '$cat' and idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'income') AS total_income", FALSE);
        $query = $this->db->get('payment')->result_array();
    } else {
        $sdate = $this->uri->segment(3);
        $edate = $this->uri->segment(4);

        $sdate1 = date("Y-m-d", strtotime($sdate));
        $edate2 = date("Y-m-d", strtotime($edate));

//                        $sql = "SELECT * FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'expense'";
        $this->db->select("(SELECT SUM(amount) FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'income') AS total_income", FALSE);
        $query = $this->db->get('payment')->result_array();
    }
    $total = $query[0]['total_income'];
    ?>
    <!--Total Expense : <b style="color: red;  " title="Total Expense :-)"><?php // echo $total;             ?></b> </h3>-->
    <div class="col-md-2"></div>
    <div class="col-md-8">

        <div id="attendance_update">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        Total Income : <?php echo $total; ?>
                        <th><div>#</div></th>
                        <th><div><?php echo get_phrase('title'); ?></div></th>
                        <th><div><?php echo get_phrase('category'); ?></div></th>
                        <th><div><?php echo get_phrase('method'); ?></div></th>
                        <th><div><?php echo get_phrase('amount'); ?></div></th>
                        <th><div><?php echo get_phrase('date'); ?></div></th>
                        <!--<th><div><?php // echo get_phrase('options');                        ?></div></th>-->
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
//                      echo $sql; exit;
                        
                    } else {
                        $sdate = $this->uri->segment(3);
                        $edate = $this->uri->segment(4);

                        $sdate1 = date("Y-m-d", strtotime($sdate));
                        $edate2 = date("Y-m-d", strtotime($edate));

                        $sql = "SELECT * FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'income'";
                    }
//                    echo $sql; exit;
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
                </tbody>
            </table>
            <center>

                <?php
                 $total = count($this->uri->segment_array());
                if ($total == 5) {
                    $cat = $this->uri->segment(3);
                    $sdate = $this->uri->segment(4);
                    $edate = $this->uri->segment(5);
                    $sdate1 = date("Y-m-d", strtotime($sdate));
                    $edate2 = date("Y-m-d", strtotime($edate));

//                        $sql = "SELECT * FROM payment WHERE expense_category_id= '$cat' and idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'expense'";
                } else {
                    $sdate = $this->uri->segment(3);
                    $edate = $this->uri->segment(4);

                    $sdate1 = date("Y-m-d", strtotime($sdate));
                    $edate2 = date("Y-m-d", strtotime($edate));

//                        $sql = "SELECT * FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'expense'";
//                    $this->db->select("(SELECT SUM(amount) FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'expense') AS total_expense", FALSE);
//                    $query = $this->db->get('payment')->result_array();
                }
                ?>



                <?php
                 $total = count($this->uri->segment_array());
                if ($total == 5) { ?>
                    <a href="<?php echo base_url(); ?>index.php?admin/income_report_print_view/<?php echo $cat; ?>/<?php echo $sdate1; ?>/<?php echo $edate2; ?>" 
                       class="btn btn-primary" target="_blank">
                           <?php echo get_phrase('print_income_sheet'); ?>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo base_url(); ?>index.php?admin/income_report_print_view/<?php echo $sdate1; ?>/<?php echo $edate2; ?>" 
                       class="btn btn-primary" target="_blank">
                        <?php echo get_phrase('print_income_sheet'); ?>
                    </a>
                <?php } ?> 

            </center>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>




















