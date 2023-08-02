<template>
    <div class="container pb-5">
      

    <div class="envelop_container "> 

 
  <div id="invoice-POS" style="background:#fff"> 
      
      <!-- <div class="barcode_info">
        <barcode v-bind:value="barcodeValue" height="30" width="1.5" >
          Show this if the rendering fails.
        </barcode>
      </div> -->
      


      <div class="repair_reciept">
        <div class="repair_reciept_table">
          <div class="repair_reciept_table_head">
              <div class="reciept_table_col w55">
                <h5>ABC Jewelers</h5>
              </div>
              <div class="reciept_table_col w45">
                <h5>Paid Repair Receipt 510 Sutters</h5>
              </div>
          </div>

          <div class="repair_reciept_table_list">
            <ul>
              <li>
                <div class="repair_reciept_table_head">
                  <div class="reciept_table_col w55">
                    <p>510 Sutters Point</p>
                    <p>Atlanta GA 30328</p>
                    <p>(404) 255-9565</p>
                    <p>www.JewelerProfit.com</p>
                  </div>
                  <div class="reciept_table_col w45">
                    <p><small>Envelope #</small> 1-12563</p>
                    <p></p>
                    <p></p>
                    <p><small>10/27/2021</small> 2:32PM</p>
                  </div>
              </div>
              </li>


              <li>
                <div class="repair_reciept_table_head">
                  <div class="reciept_table_col w55">
                    <p><small>Customer:</small> #1-98790</p>
                    <p>Harry Smith 123 Main Street Apt203 Atlanta GA 30342</p>
                    <p><small>H:</small> 404-856-7452 <small style="padding-left:10px">Cell:</small> 770-874-2145</p>
                    <p>H.Smith@Gmail.com</p>
                  </div>
                  <div class="reciept_table_col w45">
                    <p><small>You were assisted by:</small> (employee name)</p>
                    <!-- <span class="reciept_img"><custom-image src="assets/logo.png" alt="logo" class_to_pass=" mx-auto d-block"/></span> -->
                  </div>
              </div>
              </li>

              <li>
                <div class="repair_reciept_table_head">
                  <div class="reciept_table_col">
                    <p>Your item we are repairing:</p>
                    <p>“14kt yellow gold bracelet with broken lobster claw”</p> 
                  </div>
              </div>
              </li>
              <li>
                <div class="repair_reciept_table_head">
                  <div class="reciept_table_col">
                    <h5>Repair:</h5>
                    <p>Install Clasps-Lobster Claw-Includes a Soldered Jump Ring ,</p> 
                  </div>
              </div>
              </li>


              <li>
                <div class="repair_reciept_table_head">
                  <div class="reciept_table_col w65">
                    <h5>8.50x3.25mm , 14kt yg</h5> 
                  </div>
                  <div class="reciept_table_col w35">
                    <p>$95.00</p> 
                  </div>
              </div>
              </li>
              <li>
                <div class="repair_reciept_table_head">
                  <div class="reciept_table_col w65">
                    <h5>Sales tax</h5> 
                  </div>
                  <div class="reciept_table_col w35">
                    <p>$6.65</p> 
                  </div>
              </div>
              </li>
              <li>
                <div class="repair_reciept_table_head">
                  <div class="reciept_table_col w65">
                    <h5>Total</h5> 
                  </div>
                  <div class="reciept_table_col w35">
                    <p>$101.65</p> 
                  </div>
              </div>
              </li>

              <li>
                <div class="repair_reciept_table_head">
                  <div class="reciept_table_col">
                    <p><b>Picked Up By:</b> (customer) Harry Smith (or associate would type who else might have picked up this job)</p> 
                    <br>
                    <p><b>Paid By Visa Card</b> <small>10/31/2021</small> <small>5:45pm</small> Mary assisted you today.</p>
                  </div> 
              </div>
              </li>

            </ul>
          </div>
        </div>
      </div>


 
  </div> 


    </div>

    </div>
</template>

<script>
import VueBarcode from 'vue-barcode';

export default {
  components: {
    'barcode': VueBarcode
  },
  data(){
    return{
      barcodeValue: 'test',
    }
  }
}
</script>
     
<style scoped>

 ul, li { padding: 0px; margin: 0px;}
 li { list-style: none;}
 
 #invoice-POS{
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding:10mm 2mm 15mm; color: #000 !important;
  margin: 0 auto;
  width: 320px;
  background: #FFF;}

  .repair_reciept { border: 1px solid #000;}
  
  .repair_reciept_table { width: 100%;}
  .repair_reciept_table_head {width: 100%; display: table;}
  .reciept_table_col {  display: table-cell; vertical-align: top; padding: 5px 6px; border-right: 1px solid #000;border-bottom: 1px solid #000; }
.reciept_table_col:last-child { border-right: 0px;}

.reciept_table_col h5 { font-size: 13px; margin-bottom: 0px; padding: 3px 0px; font-weight: bold;}
.reciept_table_col p { font-size: 12px; margin-bottom: 2px; min-height: 18px; }
.reciept_table_col p small { font-size: 12px; margin-bottom: 0px; margin-right: 5px; }

.w55 { width: 55%;}
.w45 { width: 45%;}
.w65 { width: 65%;}
.w35 { width: 35%;}

.repair_reciept_table_list ul li:last-child .reciept_table_col { border-bottom: 0px;} 

.barcode_info { padding-bottom: 15px; padding-left: 35%;}

.barcode_info barcode { display: block; margin: auto;}

.encode > img { width: 90px !important; display: block;} 

.reciept_img {max-width: 80px; display: block; margin-top: 10px;}
.reciept_img img {width: 100%; display: block;}

</style>