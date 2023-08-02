<template>
    <div class="container px-5 py-2 mx-auto">
        <custom-alert :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
        <div class="container"> 
            <div class="text-center mt-5 mb-5">
                <div class=" p-5 ">
                    <div class="row">
                        <table class="table id_table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Customer ID</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr v-for="customer in resultQuery" :key="customer.id" @dblclick="selectCustomer(customer)">
                                    <td scope="row">{{customer.customer_id}}</td>
                                    <td>{{customer.firstname}} {{customer.lastname}}</td>
                                    <td>{{customer.primary_email}}</td>
                                    <td>{{customer.cell_phone}}</td>
                                    <!-- <td>
                                        <div class="chooseOptionDetail">
                                            <label> 
                                                <input type="radio" class="option-input radio" name="example"> 
                                        </label>
                                        </div>
                                    </td> -->
                                </tr>                                 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

 
<style scoped>

</style>

