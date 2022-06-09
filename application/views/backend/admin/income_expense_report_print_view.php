
<div id="print">
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        td {
            padding: 5px;
        }
    </style>

    <?php
        $sdate = $this->uri->segment(3);
        $edate = $this->uri->segment(4);

        $sdate1 = date("Y-m-d", strtotime($sdate));
        $edate2 = date("Y-m-d", strtotime($edate));
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
    
<center><br> 
    <div class="col-md-3" style="font-size:27px;">
  <b style=" color: black;"><u> Total Profits of ABC College</u>
<br><b style="font-size:15px;"><u>From date: <?php echo date("d-m-Y", strtotime($sdate)); ?>, To date: <?php echo date("d-m-Y", strtotime($edate)); ?></u> </b>
  </b>
      </div> <br> <br> 
     
         <div class="col-md-3" style="font-size:27px;">
 Total Income : <b style=" color: orange ;"><?php echo $total_i; ?></b>
      </div>  

         <div class="col-md-3" style="font-size:27px;">
 Total Expense : <b style=" color: red;"><?php echo $total_e; ?></b>
      </div> 

      <div class="col-md-3" style="font-size:27px;">
 Total Profit : <b style=" color: green;"><?php echo $total_profit; ?></b>
      </div> 
</center>
        
       
    </div> 



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