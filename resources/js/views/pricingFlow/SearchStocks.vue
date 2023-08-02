<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center"> 

        <!-- <h3 class="pb-5 text-uppercase">{{subHeading}}</h3> -->
 <div class="container mt-3 "> 
        <div class="row ">
            <div class="col-lg-3 text-left">
                <b-button :variant="variant" class="round-border backBtn" @click="$router.go(-1)"> 
                    <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                </b-button>
            </div>
        </div> 
        

       
          
          <div class="bg-lightblue p-5 mt-3 ">

              <div class="row align-items-center mb-4">
                  <div class="col-lg-5">
                    
                        <!-- Actual search box -->
                      <div class="form-group has-search fa_search d-flex">
                          <input type="text" class="form-control round-border p-3" placeholder="Search Sku"> 
                        
                              <default-button variant="success" text="Find" @onSubmit="onSubmit()"/> 
                      </div>
                  </div>
                  <div class="col-lg-4"></div>
                  <div class="col-lg-3">
                    <b-form-select v-model="selected_to" :options="options_to" class="round-border "></b-form-select>
                  </div>
              </div>

              <div class="row">
                  <!-- <div class="col-lg-1"></div> -->
                    <div class="col-lg-12">
                      <table class="table id_table table-striped">
                        <tbody> 
                            <tr v-for="stock in stockeList"  :key="stock.id">
                              <td scope="col" width="50">
                                <div class="checkbox_setting">
                                   <b-form-checkbox @change="toggleValue($event, stock.id)" v-model="stock.checked">
                                      <slot></slot>
                                  </b-form-checkbox>
                                </div>
                              </td>
                              <td scope="col">
                                <div class="stocks_description">
                                  <strong>{{stock.title}}</strong>
                                  <small>{{stock.size}}</small>
                                </div>
                              </td>
                              <td :class="stock.status == 'Out of Stock' ? 'outStock': ''" scope="col" width="200">{{stock.status}}</td> 
                            </tr>
                        </tbody>
                      </table> 
                    </div>
                  <!-- <div class="col-lg-1"></div> -->
          </div>
 
        </div>



</div>

    </div>

    </div>
</template>
<script>
  export default {
    data() {
      return {
        selected: [], // Must be an array reference!  
         selected_to: null,
        subHeading:"Choose Width" ,
        options_to: [
          { value: null, text: 'Select Chapter' },
          { value: 'Chapter 100', text: 'Chapter 100' },
          { value: 'Chapter 300', text: 'Chapter 300' } 
        ],


        stockeList:[{
          id:1,
          checked:false,
          title:'Barrel Clasp',
          size:'18kt+YG - 5mm x 4mm',
          status:'Out of Stock'
        },
        {
          id:2,
          checked:false,    
          title:'Box Clasp',
          size:'14kt - 5mm x 4mm',
          status:'In Stock'
        },
        {
          id:3,
          checked:false,    
          title:'Box Clasp',
          size:'14kt - 5mm x 4mm',
          status:'In Stock'
        }],
        toggleValue(checked , id){

          var result = this.stockeList.filter(function(stock) {
              return stock.id === id; // Filter out the appropriate one
          })[0]; // Get result and access the foo property)
          result.checked = checked;

        }

      }
    }
  }
</script>    
<style scoped>
.fa_search button {  min-width: auto !important; margin-left: 10px;}

.checkbox_setting .row { margin: 0px !important;
    padding: 0px !important;} 

.stocks_description strong  { display: block; color: #36a142; font-size: 20px; line-height: 1; padding-bottom: 5px;}
.stocks_description small  { display: block; line-height: 1; color: #fff; font-size: 12px;}

.outStock { color: #dc3545 !important;}


</style>