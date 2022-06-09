<hr />

<?php echo form_open(base_url() . 'index.php?admin/attendance_selector_teacher/'); ?>
<div class="row">


    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('date'); ?></label>
            <input type="text" class="form-control datepicker" name="timestamp" data-format="dd-mm-yyyy"
                   value="<?php echo date("d-m-Y"); ?>"/>
        </div>
    </div>
    <input type="hidden" name="year" value="<?php echo $running_year; ?>">

    <div class="col-md-3" style="margin-top: 20px;">
        <button type="submit" class="btn btn-info"><?php echo get_phrase('manage_attendance_teachers'); ?></button>
    </div>

</div>
<?php echo form_close(); ?>
<!--
<script type="text/javascript">
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