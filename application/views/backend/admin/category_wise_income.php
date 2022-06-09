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

<!--<script type="text/javascript">
    function select_section(class_id) {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?admin/get_section/' + class_id,
            success: function (response)
            {

                jQuery('#section_holder').html(response);
            }
        });
    }
</script>-->