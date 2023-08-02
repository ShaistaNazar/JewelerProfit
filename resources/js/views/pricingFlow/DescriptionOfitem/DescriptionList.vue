<template>
    <div class="container px-5 py-2 mx-auto">
        <custom-alert :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>

        

<basic-header/>

        <div class="container"> 

            <div class="text-center  mb-5">
                
                <div class="bg-lightblue p-5 customer_id_detail">
 
                    <h4 class="tittle_highlight text-uppercase">{{subHeading}}</h4>

                    <div class="row pb-5 mb-3">
                        <table class="table id_table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Description of items</th>
                                <th scope="col">Customer's Stated value</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Are any stones broken,
chipped, cracked or
flawed? if so Describe</th>
                                <th scope="col">Are any of these items
Not guaranteed? (not
Required)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td scope="row"><p>Lorem Ipsum dollor sit amet</p></td>
                                    <td><p>Lorem Ipsum dollor sit amet</p></td>
                                    <td><div class="profileInfo_pic">
                                            <span><custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/></span>
                                        </div></td>
                                    <td><p>Lorem Ipsum dollor sit amet</p></td>

                                    <td>
                                         <p>Lorem Ipsum dollor sit amet</p>
                                    </td>
                                </tr>                                 
                            </tbody>

                        </table>
                    </div>




                    <h3 class="pb-4 text-uppercase">{{subHeading2}}</h3>

                    <div class="row ">
                        <table class="table id_table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Approximate complain date</th>
                                <th scope="col">Watch estimate date</th>
                                <th scope="col">Wax view date</th>
                                <th scope="col">100% Complete</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td scope="row"><p>Lorem Ipsum dollor sit amet</p></td>
                                    <td><p>Lorem Ipsum dollor sit amet</p></td>
                                    <td><p>Lorem Ipsum dollor sit amet</p></td>
                                    <td><p>Lorem Ipsum dollor sit amet</p></td>

                                     
                                </tr>                                 
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- <pagination :data="resultQuery" @pagination-change-page="getCustomers"></pagination> -->

 

    </div>

</template>

<script>
  export default {
    data() {
      return {
        selected: [], // Must be an array reference!  
        subHeading:"Items in Our Care", 
        subHeading2:"Promise Dates"
      }
    }, 
  }
</script> 

<style scoped>  
.profileInfo_pic { width: 100%;}
.profileInfo_pic span { max-width: 100px ; margin: auto; display: block; margin: 0px;}
.profileInfo_pic span img { width: 100% ; margin: auto; display: block;}
</style>

