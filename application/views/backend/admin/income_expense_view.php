<hr />

<?php echo form_open(base_url() . 'index.php?admin/income_expense/'); ?>
<div class="row">

 <!--    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('category'); ?></label>
            <select name="expense_category_id" class="form-control selectboxit" >
                <option value=""><?php echo get_phrase('select_expense_category'); ?></option>
                <?php
                $categories = $this->db->get('expense_category')->result_array();
                foreach ($categories as $row):?>
                    <option value="<?php echo $row['expense_category_id']; ?>"><?php echo $row['name']; ?>                        
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div> -->


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
        <button type="submit" class="btn btn-info"><?php echo get_phrase('total_income'); ?></button>
    </div>

</div>
<?php echo form_close(); ?>


<hr />

<br>

<div class="row">
    <!--<h3>-->
    <?php
   
        $sdate = $this->uri->segment(3);
        $edate = $this->uri->segment(4);

        $sdate1 = date("Y-m-d", strtotime($sdate));
        $edate2 = date("Y-m-d", strtotime($edate));

//                        $sql = "SELECT * FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'expense'";
          $this->db->select("(SELECT SUM(amount) FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'income') AS total_income", FALSE);
        $query1 = $this->db->get('payment')->result_array();
        $total_i = $query1[0]['total_income'];

        
   
        $this->db->select("(SELECT SUM(amount) FROM payment WHERE idate >= '$sdate1' and idate <= '$edate2' and payment_type = 'expense') AS total_expense", FALSE);
        $query = $this->db->get('payment')->result_array();
   
    $total_e = $query[0]['total_expense'];

    $total_profit = $total_i-$total_e;

    ?>
    <!--Total Expense : <b style="color: red;  " title="Total Expense :-)"><?php // echo $total;             ?></b> </h3>-->
   
    <div class="col-md-12">

         <div class="col-md-4" style="font-size:27px;">
 Total Income : <b style=" color: orange ;"><?php echo $total_i; ?></b>
      </div>  

         <div class="col-md-4" style="font-size:27px;">
 Total Expense : <b style=" color: red;"><?php echo $total_e; ?></b>
      </div> 

      <div class="col-md-4" style="font-size:27px;">
 Total Profit : <b style=" color: green;"><?php echo $total_profit; ?></b>
      </div> <br><br><br><br>

        
       
    </div>
    <center>
        <a href="<?php echo base_url(); ?>index.php?admin/income_expense_report_print_view/<?php echo $sdate1; ?>/<?php echo $edate2; ?>" 
                       class="btn btn-primary" target="_blank">
                        <?php echo get_phrase('print_expense_sheet'); ?>
                    </a>
    </center>
     
</div>




















