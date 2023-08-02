<template>
     <div class="container mx-auto">
    <custom-alert
      :showDismissibleAlert="showDismissibleAlert"
      :msg="alertMsg"
      :variant="variant"
    />


   <!-- <div class="vld-parent"  v-show="$store.state.dataStore.isLoading">
      <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
  </div> -->
    <!-- <custom-image
      src="assets/logo.png"
      alt="logo"
      class_to_pass="responsive-logo mx-auto my-4 d-block"
    /> -->

    <div class="container px-0 ">
      <man-with-heading heading="Previous Customers"/>
      <div class="row pt-2">
        <div class="col-lg-3 text-left">
          <b-button
            :variant="variant"
            class="round-border backBtn"
            @click="$router.go(-1)"
          >
            <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
          </b-button>
        </div>
      </div>
      <div class="text-center mt-3 mb-4" v-if="resultQuery.data && resultQuery.data.length > 0">
        <div class="bg-lightblue p-4 p-lg-5 customer_id_detail">
          <div class="row mb-2 mb-lg-5">
            <div class="col-lg-5">
              <!-- Actual search box -->
              <div class="form-group has-search fa_search">
                <input
                  type="text"
                  class="form-control round-border p-4"
                  placeholder="Search by name or customer id"
                  v-model="searchQuery"
                  @keyup="getCustomers"
                />
                <b><b-icon icon="search"></b-icon></b>
              </div>
            </div>
          </div>

          <div class="row m-0" style="overflow-x: auto">
            <table class="table id_table table-hover">
              <thead>
                <tr>
                  <th scope="col">Customer ID</th>
                  <th scope="col">Full Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone Number</th>
                  <!-- <th scope="col">Action</th> -->
                </tr>
              </thead>
              <tbody>
                <tr
                  style="cursor:pointer"
                  v-for="customer in resultQuery.data"
                  :key="customer.id"
                >
                  <td scope="row" class="txt" @click="selectCustomer(customer)">{{ customer.customer_id }}</td>
                  <td class="txt" @click="selectCustomer(customer)">{{ customer.firstname }} {{ customer.lastname }}</td>
                  <td class="txt" @click="selectCustomer(customer)">{{ customer.email }}</td>
                  <td class="txt" @click="selectCustomer(customer)">{{ customer.cell_phone }}</td>
                  <td class="d-none">
                    <div class="addEdit">
                      <!-- <button type="button" class="text-success" data-toggle="modal" data-target=".bd-example-modal-lg"> 
                      <span
                        type="button"
                        class="text-success"
                        v-b-modal.modal-lg
                        @click="editCustomer(customer.id)"
                      >
                       
                        <b-icon
                          icon="pencil-square"
                          aria-hidden="true"
                        ></b-icon>
                      </span>
                      <button
                        class="text-danger"
                        @click="deleteCustomer(customer.primary_email)"
                      >
                        <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
                      </button>-->
                    </div>
                  </td> 
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="container customer_id_detail  mt-3 p-3" v-else>
        <div class="container info-div" :class="$mq">
          <div
            class="
              bg-lightblue
              no-border
              text-center
              d-flex
              flex-nowrap
            "
          >
            <div class="my-auto mr-3">
              <b-icon icon="info-circle-fill" variant="light"></b-icon>
            </div>
            <span>
              No customer exists for this shop, please 
              <router-link :to="{name:'add-new-customer'}" class="text-warning"
                :class="$store.state.dataStore.sale_person_id ? '' : 'disable_div'"> 
               <strong>Create First</strong>
              </router-link>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center sett_pagintation pb-3">
      <pagination
        class="justify-content-center"
        :data="resultQuery"
        @pagination-change-page="getCustomers"
      ></pagination>
    </div>

    <!-- <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"> -->
    <b-modal
      id="modal-lg"
      size="lg"
      hide-footer
      hide-header
      body-bg-variant="modelbg"
    >
    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
      <div class="">
        <div class="add_model_bg">
          <div class="row myForn  p-3">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 p3">
              <b-form @reset="$v.$reset()" class="personal-form py-5">
                <div>
                  <b-form-group>
                    <h5 class="mb-3 text-center">Customer Name</h5>

                    <b-form-input
                      disabled
                      type="text"
                      id="customer_id"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Customer.CustomerID.$error }"
                      placeholder="Customer ID"
                      v-model.trim="$v.Customer.CustomerID.$model"
                      @blur="$v.Customer.CustomerID.$touch"
                      name="customer_id"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Customer.CustomerID.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Customer.CustomerID.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Customer.CustomerID.$params.maxLength.max,
                        })
                      }}
                    </div>

                    <b-form-input
                      type="text"
                      id="customer_firstname_field"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Customer.firstname.$error }"
                      placeholder="First name"
                      v-model.trim="$v.Customer.firstname.$model"
                      @blur="$v.Customer.firstname.$touch"
                      name="firstname"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Customer.firstname.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Customer.firstname.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Customer.firstname.$params.maxLength.max,
                        })
                      }}
                    </div>

                    <b-form-input
                      type="text"
                      id="customer_lastname_field"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Customer.lastname.$error }"
                      placeholder="Last name"
                      v-model.trim="$v.Customer.lastname.$model"
                      @blur="$v.Customer.lastname.$touch"
                      name="lastname"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Customer.lastname.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Customer.lastname.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Customer.lastname.$params.maxLength.max,
                        })
                      }}
                    </div>
                    <div>
                      <label for="gender">Gender</label>
                    </div>
                    <div>
                      <div class="text-center">
                        <b-form-group v-slot="{ ariaDescribedby }">
                          <b-form-radio-group
                            disabled
                            v-model="Customer.gender"
                            :options="gender_options"
                            :aria-describedby="ariaDescribedby"
                            name="gender"
                          ></b-form-radio-group>
                        </b-form-group>
                      </div>
                    </div>
                  </b-form-group>
                  <b-form-group>
                    <h5 class="mb-3 pt-4 text-center">Phone</h5>

                    <b-form-input
                      type="text"
                      id="customer_home_Field"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Phone.home.$error }"
                      placeholder="Home"
                      v-model.trim="$v.Phone.home.$model"
                      @blur="$v.Phone.home.$touch"
                      name="home"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Phone.home.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Phone.home.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Phone.home.$params.maxLength.max,
                        })
                      }}
                    </div>

                    <b-form-input
                      type="text"
                      id="cellField"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Phone.cell.$error }"
                      placeholder="Cell"
                      v-model.trim="$v.Phone.cell.$model"
                      @blur="$v.Phone.cell.$touch"
                      name="cell"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Phone.cell.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Phone.cell.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Phone.cell.$params.maxLength.max,
                        })
                      }}
                    </div>

                    <b-form-input
                      type="text"
                      id="workField"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Phone.work.$error }"
                      placeholder="Work"
                      v-model.trim="$v.Phone.work.$model"
                      @blur="$v.Phone.work.$touch"
                      name="work"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Phone.work.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Phone.work.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Phone.work.$params.maxLength.max,
                        })
                      }}
                    </div>

                    <b-form-input
                      type="text"
                      id="alternativeField"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Phone.alternative.$error }"
                      placeholder="Alternative"
                      v-model.trim="$v.Phone.alternative.$model"
                      @blur="$v.Phone.alternative.$touch"
                      name="alternative"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Phone.alternative.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Phone.alternative.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Phone.alternative.$params.maxLength.max,
                        })
                      }}
                    </div>
                    <div>
                      <label for="gender"
                        >May we text you to this number as a contact
                        method?</label
                      >
                    </div>
                    <div>
                      <b-form-group v-slot="{ ariaDescribedby }">
                        <b-form-radio-group
                          v-model="Customer.shouldContact"
                          :options="yesOrNo"
                          :aria-describedby="ariaDescribedby"
                          name="shouldContact"
                        ></b-form-radio-group>
                      </b-form-group>
                    </div>
                  </b-form-group>

                  <b-form-group>
                    <h5 class="mb-3 pt-4 text-center">Emails</h5>
                    <b-form-input
                      type="text"
                      id="primaryField"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Emails.primary.$error }"
                      placeholder="Primary name"
                      v-model.trim="$v.Emails.primary.$model"
                      @blur="$v.Emails.primary.$touch"
                      name="primary_name"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Emails.primary.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Emails.primary.email"
                    >
                      {{ $t("form.validation.validEmail") }}
                    </div>

                    <b-form-input
                      type="text"
                      id="secondaryField"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Emails.secondary.$error }"
                      placeholder="Secondary name"
                      v-model.trim="$v.Emails.secondary.$model"
                      @blur="$v.Emails.secondary.$touch"
                      name="secondary_name"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Emails.secondary.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Emails.secondary.email"
                    >
                      {{ $t("form.validation.validEmail") }}
                    </div>
                  </b-form-group>

                  <b-form-group>
                    <h5 class="mb-3 pt-4 text-center">Address</h5>

                    <b-form-input
                      type="text"
                      id="street_id"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Address.street.$error }"
                      placeholder="Street"
                      v-model.trim="$v.Address.street.$model"
                      @blur="$v.Address.street.$touch"
                      name="street_id"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Address.street.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Address.street.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Address.street.$params.maxLength.max,
                        })
                      }}
                    </div>

                    <b-form-input
                      type="text"
                      id="apartment_id"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Address.apartment.$error }"
                      placeholder="Suit/Apt"
                      v-model.trim="$v.Address.apartment.$model"
                      @blur="$v.Address.apartment.$touch"
                      name="customer_id"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Address.apartment.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Address.apartment.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Address.apartment.$params.maxLength.max,
                        })
                      }}
                    </div>

                    <b-form-input
                      type="text"
                      id="city_id"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Address.city.$error }"
                      placeholder="City"
                      v-model.trim="$v.Address.city.$model"
                      @blur="$v.Address.city.$touch"
                      name="customer_id"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Address.city.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Address.city.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Address.city.$params.maxLength.max,
                        })
                      }}
                    </div>

                    <b-form-input
                      type="text"
                      id="zip_id"
                      class="round-border mx-auto mb-3"
                      :class="{ 'is-invalid': $v.Address.zip.$error }"
                      placeholder="State zip"
                      v-model.trim="$v.Address.zip.$model"
                      @blur="$v.Address.zip.$touch"
                      name="zip_id"
                    ></b-form-input>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Address.zip.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.Address.zip.maxLength"
                    >
                      {{
                        $t("form.validation.maxLength", {
                          num: $v.Address.zip.$params.maxLength.max,
                        })
                      }}
                    </div>
                  </b-form-group>
                </div>
                <div class="text-center mt-3">
                  <default-button
                    class=""
                    variant="success"
                    text="Update Customer"
                    @onSubmit="UpdateCustomer()"
                  />
                </div>
              </b-form>
            </div>
            <div class="col-lg-2"></div>
          </div>
        </div>
      </div>
    </b-modal>
  </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import { mapGetters, mapActions } from "vuex";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, email } from "vuelidate/lib/validators";

import Button from "../../../components/Global/Button.vue";

export default {
  components: { Button,
  'loading':Loading },
  setup() {
    return { v$: useVuelidate() };
  },
  mounted() {
  },

  data() {
    return {
      termsOfService: "",
      to_signin_link_google: "",
      to_signin_link_fb: "",
      User: {
        email: "",
        password: "",
      },
      alertMsg: "",
      showDismissibleAlert: false,
      alertMsg: "",
      variant: null,
      customers: {},
      searchQuery: "",
      note:'No customer exists for this shop, please create first.',
      Customer: {
        id: null,
        CustomerID: "",
        firstname: "",
        lastname: "",
        gender: "f",
        shouldContact: 1,
      },
      Phone: {
        work: "",
        home: "",
        cell: "",
        alternative: "",
      },
      Emails: {
        primary: "",
        secondary: "",
      },
      Address: {
        street: "",
        apartment: "",
        city: "",
        zip: "",
      },
      gender_options: [
        { text: "Female", value: "f" },
        { text: "Male", value: "m" },
      ],
      yesOrNo: [
        { text: "Yes", value: 1 },
        { text: "No", value: 0 },
      ],
    };
  },
  validations: {
    Customer: {
      CustomerID: {
        required,
        maxLength: maxLength(30),
      },
      firstname: {
        required,
        maxLength: maxLength(30),
      },
      lastname: {
        required,
        maxLength: maxLength(30),
      },
      gender: {
        required,
      },
    },
    Phone: {
      home: {
        required,
        maxLength: maxLength(30),
      },
      cell: {
        required,
        maxLength: maxLength(45),
      },
      work: {
        required,
        maxLength: maxLength(12),
      },
      alternative: {
        required,
        maxLength: maxLength(12),
      },
    },
    Emails: {
      primary: {
        required,
        email,
        maxLength: maxLength(45),
      },
      secondary: {
        required,
        email,
        maxLength: maxLength(45),
      },
    },
    Address: {
      street: {
        required,
        maxLength: maxLength(50),
      },
      apartment: {
        required,
        maxLength: maxLength(50),
      },
      city: {
        required,
        maxLength: maxLength(45),
      },
      zip: {
        required,
        maxLength: maxLength(100),
      },
    },
  },
  mounted() {
    this.getCustomers();
  },
  computed: {
    resultQuery() {
      // if (this.searchQuery && this.searchQuery != "") {
      //   console.log(typeof this.customers);
      //   return this.customers.filter((customer) => {
      //     console.log(this.customers.data);
      //     console.log(customer);
      //     return this.searchQuery
      //       .toLowerCase()
      //       .split(" ")
      //       .every(
      //         (v) =>
      //           customer.customer_id.toLowerCase().includes(v) ||
      //           customer.firstname.toLowerCase().includes(v) ||
      //           customer.lastname.toLowerCase().includes(v)
      //       );
      //   });
      // } else {
        return this.customers;
      // }
    },
  },

  watch: {
    searchQuery: function (newValue, oldValue) {
      resultQuery.data && resultQuery.data.length > 0
        if(newValue && newValue!== '')
        {
          this.remove_customer_list_panel = true;
        }
      }
    },
  methods: {
    ...mapActions("dataStore", ["setTheCustomer",'removeCustomer','setPreviousPageOnCustomerChange','setLoader']),
    /**
     * edit customer
     */
    editCustomer(id) {
      this.setLoader(true);
      let token = localStorage.getItem("token");

      axios
        .post(
          "/api/edit-customer", 
          {
            // customer
            id: id,
          },
          {
            headers: {
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => {


          var customer = response.data.data;
          console.log(response.data)
          this.Customer.id = customer.id;
          this.Customer.CustomerID = customer.customer_id;
          this.Customer.firstname = customer.firstname;
          this.Customer.lastname = customer.lastname;
          this.Customer.gender = customer.gender;
          this.Customer.shouldContact = customer.should_contact;
          this.Phone.work = customer.work_phone;
          this.Phone.home = customer.home_phone;
          this.Phone.cell = customer.cell_phone;
          this.Phone.alternative = customer.alternative;
          this.Emails.primary = customer.primary_email;
          this.Emails.secondary = customer.secondary_email;
          this.Address.street = customer.street_address;
          this.Address.apartment = customer.apartment;
          this.Address.city = customer.city;
          this.Address.zip = customer.zip;

          this.setLoader(false);
          this.getCustomers();
          // this.$router.push(
          //     {
          //         name:'customer-id'
          //     }
          // )
        })
        .catch((error) => {
          this.setLoader(false);
          if (error.response) {
            if (error.response.data.errors) {
              let msg =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.$emit("showAlert", [msg, "danger"]);
            } else if (error.response.response_header) {
              if (error.response.response_header.response_message) {
                this.$emit("showAlert", [
                  error.response.data.response_header.response_message,
                  "danger",
                ]);
              }
            } else if (error.response.data) {
              if (error.response.data.response_header) {
                if (error.response.data.response_header.response_message) {
                  this.$emit("showAlert", [
                    error.response.data.response_header.response_message,
                    "danger",
                  ]);
                }
              } else {
                this.$emit("showAlert", [error.response.data, "danger"]);
              }
            }
          } else {
            this.$emit("showAlert", [error, "danger"]);
          }
        });
    },
    /***
     * call to delete customer API
     */
    deleteCustomer(email) {
      this.setLoader(true);

      let token = localStorage.getItem("token");

      axios
        .post(
          "/api/delete-customer",
          {
            // customer
            email: email,
          },
          {
            headers: {
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => {
          this.setLoader(false);
          this.$emit("showAlert", [
            "Customer deleted successfully.",
            "success",
          ]);
          if (this.$store.state.dataStore.customer_details['email'] == email) {
            this.removeCustomer();
          }
          this.getCustomers();
        })
        .catch((error) => {
          this.setLoader(false);
          if (error.response) {
            if (error.response.data.errors) {
              let msg =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.$emit("showAlert", [msg, "danger"]);
            } else if (error.response.response_header) {
              if (error.response.response_header.response_message) {
                this.$emit("showAlert", [
                  error.response.data.response_header.response_message,
                  "danger",
                ]);
              }
            } else if (error.response.data) {
              if (error.response.data.response_header) {
                if (error.response.data.response_header.response_message) {
                  this.$emit("showAlert", [
                    error.response.data.response_header.response_message,
                    "danger",
                  ]);
                }
              } else {
                this.$emit("showAlert", [error.response.data, "danger"]);
              }
            }
          } else {
            this.$emit("showAlert", [error, "danger"]);
          }
        });
    },
    UpdateCustomer() {
      this.$v.$touch();

      if (this.$v.$invalid) {
        let errorMsg = "";

        // Customer
        if (this.$v.Customer.CustomerID.$error) {
          errorMsg = "CustomerID";
        }

        if (this.$v.Customer.firstname.$error) {
          errorMsg = errorMsg ? errorMsg + ", firstname" : "firstname";
        }

        if (this.$v.Customer.lastname.$error) {
          errorMsg = errorMsg ? errorMsg + ", lastname" : "lastname";
        }

        if (this.$v.Customer.gender.$error) {
          errorMsg = errorMsg ? errorMsg + ", gender" : "gender";
        }

        // Phone
        if (this.$v.Phone.home.$error) {
          errorMsg = "home";
        }

        if (this.$v.Phone.cell.$error) {
          errorMsg = errorMsg ? errorMsg + ", cell" : "cell";
        }

        if (this.$v.Phone.work.$error) {
          errorMsg = errorMsg ? errorMsg + ", work" : "work";
        }

        if (this.$v.Phone.alternative.$error) {
          errorMsg = errorMsg ? errorMsg + ", alternative" : "alternative";
        }

        // Emails
        if (this.$v.Emails.primary.$error) {
          errorMsg = errorMsg ? errorMsg + ", primary email" : "primary email";
        }

        if (this.$v.Emails.secondary.$error) {
          errorMsg = errorMsg
            ? errorMsg + ", secondary email"
            : "secondary email";
        }

        // Address
        if (this.$v.Address.street.$error) {
          errorMsg = "Address";
        }

        if (this.$v.Address.apartment.$error) {
          errorMsg = errorMsg ? errorMsg + ", apartment" : "apartment";
        }

        if (this.$v.Address.city.$error) {
          errorMsg = errorMsg ? errorMsg + ", city" : "city";
        }

        if (this.$v.Address.zip.$error) {
          errorMsg = errorMsg ? errorMsg + ", zip" : "zip";
        }

        if (errorMsg !== "") {
          this.$emit("showAlert", [
            this.$t("form.validation.mandatoryFieldsError", {
              errors: errorMsg,
            }),
            "danger",
          ]);

          return;
        }
      }
      this.setLoader(true);

      let token = localStorage.getItem("token");

      axios
        .post(
          "/api/update-customer",
          {
            // customer
            id: this.Customer.id,
            customer_id: this.Customer.CustomerID,
            firstname: this.Customer.firstname,
            lastname: this.Customer.lastname,
            gender: this.Customer.gender,
            should_contact: this.Customer.shouldContact,

            //phone
            home_phone: this.Phone.home,
            work_phone: this.Phone.work,
            cell_phone: this.Phone.cell,
            alternative: this.Phone.alternative,

            //Email
            primary_email: this.Emails.primary,
            secondary_email: this.Emails.secondary,

            //Address
            street_address: this.Address.street,
            apartment: this.Address.apartment,
            city: this.Address.city,
            zip: this.Address.zip,
          },
          {
            headers: {
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => {
          this.setLoader(false);
          this.$emit("showAlert", [
            "Customer updated successfully.",
            "success",
          ]);
          this.getCustomers();
          this.$bvModal.hide('modal-lg');
        })
        .catch((error) => {
          this.setLoader(false);
          if (error.response) {
            if (error.response.data.errors) {
              let msg =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.$emit("showAlert", [msg, "danger"]);
            } else if (error.response.response_header) {
              if (error.response.response_header.response_message) {
                this.$emit("showAlert", [
                  error.response.data.response_header.response_message,
                  "danger",
                ]);
              }
            } else if (error.response.data) {
              if (error.response.data.response_header) {
                if (error.response.data.response_header.response_message) {
                  this.$emit("showAlert", [
                    error.response.data.response_header.response_message,
                    "danger",
                  ]);
                }
              } else {
                this.$emit("showAlert", [error.response.data, "danger"]);
              }
            }
          } else {
            this.$emit("showAlert", [error, "danger"]);
          }
        });
    },

    /**
     *
     */
    selectCustomer(customer) {
      this.setTheCustomer(customer);
      if(this.$store.state.dataStore.previous_page_on_customer_change != ""){
        this.$router.push(this.$store.state.dataStore.previous_page_on_customer_change).catch(()=>{});
        this.setPreviousPageOnCustomerChange("");
      }else{
        this.$router.push({name:'purpose-of-job'});
      }
    },

    /**
     * alert generator
     */

    showAlert($event) {
      this.alertMsg = $event[0];
      this.variant = $event[1];
      this.showDismissibleAlert = true;
    },

    /**
     * Clear alert
     */

    clearAlert() {
      this.alertMsg = "";
      this.variant = "";
      this.showDismissibleAlert = false;
    },

    getCustomers(page = 1) {

      this.setLoader(true);
      var token = localStorage.getItem("token");
      axios
        .get(`/api/get-customers?filter=${this.searchQuery}&page=` + page, {
          headers: {
            Authorization: "Bearer " + token,
          },
        })
        .then((response) => {
          this.setLoader(false);
          this.customers = response.data.data;
          console.log(response.data.data);
          // this.customers = Object.assign({}, this.customers); // {0:"a", 1:"b", 2:"c"}
          // let user = response.data.data;
          // let msg = response.data.response_header.response_message;
        })
        .catch((error) => {
         this.setLoader(false);
          if (error.response) {
            if (error.response.data.errors) {
              let msg =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.$emit("showAlert", [msg, "danger"]);
            } else if (error.response.data.response_header.response_message) {
              this.$emit("showAlert", [
                error.response.data.response_header.response_message,
                "danger",
              ]);
            }
          } else {
            this.$emit("showAlert", [error, "danger"]);
          }
        });
    },
  },
};
</script>

<style scoped>
.modal-open #modal-lg___BV_modal_content_ {
  background-color: red !important;
}

.txt:hover {
    text-decoration: underline;
}
</style>

