<template>
  <div class="container">
    <custom-alert
      v-if="showDismissibleAlert"
      :showDismissibleAlert="showDismissibleAlert"
      :msg="alertMsg"
      :variant="variant"
    />
    <div class="row pb-4">
      <div class="col-lg-6 col-md-6">
        <div class="shank_tittle">
          <b-button
            :variant="variant"
            class="round-border backBtn"
            @click="$router.go(-1)"
          >
            <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
          </b-button>
          <h5 class="m-0 p-0 ml-3">Jeweler Management</h5>
        </div>
      </div>

      <div class="col-lg-2 col-md-2" ></div>

      <div class="col-lg-4 col-md-4" > 
          
      <div class="form-group has-search fa_search">
        <input
          type="text"
          class="form-control round-border p-4"
          placeholder="Search by name,email or contact no."
          v-model="searchQuery"
          @keyup="getCustomers"
        />
        <b><b-icon icon="search"></b-icon></b>
      </div>

        <div class="customer_sortout text-right"  v-if="resultQuery.data && resultQuery.data.length > 0">
          <button class="addBTTn" @click="redirectToAddCustomer()">
            <strong>Add New</strong>
          </button>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- <div class="col-lg-3 ">
                <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/>
            </div>  -->
      <div class="col-lg-12">
        <div
          class="retail_price_detail"
          v-for="(item, index) in resultQuery.data"
          :key="index"
          :set="ite = resultQuery.data[0]"
        >{{item}}
          <div class="retail_price_inner">   
            <div class="row pb-3 pt-3">
              <span class="table_arrow p-0">
                <b-icon
                  icon="trash-fill"
                  class="text-danger"
                  aria-hidden="true"
                ></b-icon>
                <b-icon
                  icon="pencil-square"
                  aria-hidden="true"
                  @click="setItemAsActiveItem(item)"
                ></b-icon>
              </span>
              <div class="col-md-4 pr-0">
                <div class="retail_price_col">
                  <div class="retail_price_col_head">
                    <strong>Customer ID:</strong>
                    {{ item.customer_id }}
                  </div>
                </div>
              </div>
              <div class="col-md-8 pr-0 pl-0">
                <div class="retail_price_col">
                  <div class="retail_price_col_head">
                    <strong>Email:</strong>
                    {{ item.email }}
                  </div>
                </div>
              </div>

              <!-- <div class="col-md-4 pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <strong>Email:</strong>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-8 pr-0  pl-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    {{item.email}}
                                </div>  
                            </div>
                        </div>  -->
            </div>

            <b-collapse
              id="collapse-find-sku"
              class=""
              :visible="active_item == item.customer_id"
            >
              <div class="pending_watches_list pendingField">
                <ul class="m-0 p-0">
                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>First Name</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_firstname_field"
                              :class="{
                                'is-invalid': $v.Customer.firstname.$error,
                              }"
                              placeholder=""
                              :value="item.firstname"
                              @change="setFirstName($event)"
                              name="firstname"
                            >
                            </b-form-input>
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
                                  num: $v.Customer.firstname.$params.maxLength
                                    .max,
                                })
                              }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Last Name</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_lastname_field"
                              :class="{
                                'is-invalid': $v.Customer.lastname.$error,
                              }"
                              placeholder=""
                              :value="item.lastname"
                              @change="setLastName($event)"
                              name="lastname"
                            >
                            </b-form-input>
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
                                  num: $v.Customer.lastname.$params.maxLength
                                    .max,
                                })
                              }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Spouce First Name</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_spouce_f_name_field"
                              :class="{
                                'is-invalid': $v.Customer.spouce_f_name.$error,
                              }"
                              placeholder=""
                              :value="item.spouce_f_name"
                              @change="setSpouceFName($event)"
                              name="spouce_f_name"
                            >
                            </b-form-input>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.spouce_f_name.maxLength"
                            >
                              {{
                                $t("form.validation.maxLength", {
                                  num: $v.Customer.spouce_f_name.$params
                                    .maxLength.max,
                                })
                              }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Spouce Last Name</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_spouce_l_name_field"
                              :class="{
                                'is-invalid': $v.Customer.spouce_l_name.$error,
                              }"
                              placeholder=""
                              :value="item.spouce_l_name"
                              @change="setSpouceLName($event)"
                              name="spouce_l_name"
                            >
                            </b-form-input>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.spouce_l_name.maxLength"
                            >
                              {{
                                $t("form.validation.maxLength", {
                                  num: $v.Customer.spouce_l_name.$params
                                    .maxLength.max,
                                })
                              }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Gender</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <span v-if="item.gender == 'f'"> Female </span>
                            <span v-if="item.gender == 'm'"> Male </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Birth Date</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-datepicker
                              id="date-picker-label"
                              v-model="item.birth_date"
                              class="round-border p-2 text-left"
                            ></b-form-datepicker>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Email</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            {{ $v.Customer.email }}
                            <b-form-input
                              type="text"
                              id="customer_email_field"
                              :class="{
                                'is-invalid': $v.Customer.email.$error,
                              }"
                              placeholder=""
                              :value="item.email"
                              @change="setEmail($event)"
                              name="email"
                            >
                            </b-form-input>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.email.required"
                            >
                              {{ $t("form.validation.required") }}
                            </div>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.email.email"
                            >
                              {{ $t("form.validation.validEmail") }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Contact No.</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            {{ $v.Customer.cell_phone }}
                            <b-form-input
                              type="text"
                              id="customer_cell_phone_field"
                              :class="{
                                'is-invalid': $v.Customer.cell_phone.$error,
                              }"
                              placeholder=""
                              :value="item.cell_phone"
                              @change="setCellPhone($event)"
                              name="cell_phone"
                            >
                            </b-form-input>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.cell_phone.required"
                            >
                              {{ $t("form.validation.required") }}
                            </div>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.cell_phone.maxLength"
                            >
                              {{
                                $t("form.validation.maxLength", {
                                  num: $v.Customer.cell_phone.$params.maxLength
                                    .max,
                                })
                              }}
                            </div>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.cell_phone.minLength"
                            >
                              {{
                                $t("form.validation.minLength", {
                                  num: $v.Customer.cell_phone.$params.minLength
                                    .min,
                                })
                              }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Alternative Contact No.</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_alternative_field"
                              :class="{
                                'is-invalid': $v.Customer.alternative.$error,
                              }"
                              placeholder=""
                              :value="item.alternative"
                              @change="setAlternative($event)"
                              name="alternative"
                            >
                            </b-form-input>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.alternative.required"
                            >
                              {{ $t("form.validation.required") }}
                            </div>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.alternative.maxLength"
                            >
                              {{
                                $t("form.validation.maxLength", {
                                  num: $v.Customer.alternative.$params.maxLength
                                    .max,
                                })
                              }}
                            </div>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.alternative.minLength"
                            >
                              {{
                                $t("form.validation.minLength", {
                                  num: $v.Customer.alternative.$params.minLength
                                    .min,
                                })
                              }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class="">
                            <b
                              >May we contact on this number as our primary
                              contact method.</b
                            >
                          </p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-group>
                              <b-form-radio-group
                                v-model="item.should_contact"
                                :options="options"
                                class="mb-3"
                                value-field="item"
                                text-field="name"
                              ></b-form-radio-group>
                            </b-form-group>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Street Address</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_street_address_field"
                              :class="{
                                'is-invalid': $v.Customer.street_address.$error,
                              }"
                              placeholder=""
                              :value="item.street_address"
                              @change="setStreetAddress($event)"
                              name="street_address"
                            >
                            </b-form-input>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.street_address.required"
                            >
                              {{ $t("form.validation.required") }}
                            </div>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.street_address.maxLength"
                            >
                              {{
                                $t("form.validation.maxLength", {
                                  num: $v.Customer.street_address.$params
                                    .maxLength.max,
                                })
                              }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>Apartment</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_apartment_field"
                              :class="{
                                'is-invalid': $v.Customer.apartment.$error,
                              }"
                              placeholder=""
                              :value="item.apartment"
                              @change="setApartment($event)"
                              name="apartment"
                            >
                            </b-form-input>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>City</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_city_field"
                              :class="{ 'is-invalid': $v.Customer.city.$error }"
                              placeholder=""
                              :value="item.city"
                              @change="setCity($event)"
                              name="city"
                            >
                            </b-form-input>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.city.required"
                            >
                              {{ $t("form.validation.required") }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-unstyled">
                    <div class="row align-items-center">
                      <div class="col-md-4 pr-0">
                        <div class="retail_price_col_info">
                          <p class=""><b>State Zip</b></p>
                        </div>
                      </div>
                      <div class="col-md-8 pl-0 pr-0">
                        <div class="retail_price_col_info pl-0">
                          <div class="retail_price_col_info">
                            <b-form-input
                              type="text"
                              id="customer_zip_field"
                              :class="{ 'is-invalid': $v.Customer.zip.$error }"
                              placeholder=""
                              :value="item.zip"
                              @change="setZip($event)"
                              name="zip"
                            >
                            </b-form-input>
                            <div
                              class="invalid-feedback"
                              v-if="!$v.Customer.zip.required"
                            >
                              {{ $t("form.validation.required") }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>

                <div class="pt-4">
                  <div class="text-center">
                    <default-button
                      class=""
                      variant="warning"
                      text="Save"
                      @onSubmit="updateCustomer(item)"
                    />
                    <default-button class="" variant="warning" text="Cancel" />
                  </div>
                </div>
              </div>
            </b-collapse>
          </div>
        </div>
      </div>
      <div class="w-100 pt-4">
        <div class="text-center sett_pagintation pb-3">
          <pagination
            class="justify-content-center"
            :data="resultQuery"
            @pagination-change-page="getCustomers"
          ></pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Button from "../../components/Global/Button.vue";
/**
 * Vuelidate items
 */

import {
  required,
  maxLength,
  minLength,
  email,
  containsNumber,
  minValue,
} from "vuelidate/lib/validators";
export default {
  components: {
    Button,
  },
  mounted() {
    this.getCustomers();
  },
  computed: {
    resultQuery() {
      return this.customers;
    },
  },
  data() {
    return {
      visible_find_sku: false,
      showDismissibleAlert: false,
      variant: null,
      searchQuery: "",
      active_item: "",
      customers: {},
      selected: "A",
      options: [
        { item: 1, name: "Yes" },
        { item: 0, name: "No" },
      ],
      contact_methods: [
        { value: 1, text: "Yes" },
        { value: 0, text: "No" },
      ],
      Customer: {
        firstname_0: "",
        lastname_0: "",
        spouce_f_name_0: "",
        spouce_l_name_0: "",
        cell_phone_0: "",
        alternative_0: "",
        should_contact_0: "",
        email_0: "",
        street_address_0: "",
        apartment_0: "",
        city_0: "",
        zip_0: "",
      },
      temp_Customer: {
        firstname: "abc",
        lastname: "",
        spouce_f_name: "",
        spouce_l_name: "",
        cell_phone: "",
        alternative: "",
        should_contact: "",
        email: "",
        street_address: "",
        apartment: "",
        city: "",
        zip: "",
      },
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
      spouce_f_name: {
        maxLength: maxLength(30),
      },
      spouce_l_name: {
        maxLength: maxLength(30),
      },
      cell_phone: {
        required,
        maxLength: maxLength(13),
        minLength: minLength(13),
      },
      alternative: {
        required,
        maxLength: maxLength(13),
        minLength: minLength(13),
      },
      should_contact: {
        required,
      },
      email: {
        required,
        email,
      },
      street_address: {
        required,
        maxLength: maxLength(150),
      },
      apartment: {
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

  watch: {
    searchQuery: function (newValue, oldValue) {
      resultQuery.data && resultQuery.data.length > 0;
      if (newValue && newValue !== "") {
        this.remove_customer_list_panel = true;
      }
    },
  },
  methods: {
    ...mapActions("dataStore", ["removeTheItem", "setLoader"]),

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

    /**
     * update
     */
    setFirstName(value) {
      console.log("event_value", value);
      this.Customer.firstname = value;
      this.$v.Customer.firstname.$touch();
    },

    /**
     * update
     */
    setLastName(value) {
      console.log("event_value", value);

      this.Customer.lastname = value;
      this.$v.Customer.lastname.$touch();
    },

    /**
     * update
     */
    setSpouceFName(value) {
      console.log("event_value", value);

      this.Customer.spouce_f_name = value;
      this.$v.Customer.spouce_f_name.$touch();
    },

    /**
     * update
     */
    setSpouceLName(value) {
      console.log("event_value", value);

      this.Customer.spouce_l_name = value;
      this.$v.Customer.spouce_l_name.$touch();
    },

    /**
     * update
     */
    setCellPhone(value) {
      console.log(value);
      console.log("event_value", value);

      this.Customer.cell_phone = value;
      this.$v.Customer.cell_phone.$touch();
    },

    /**
     * uodate
     */
    setAlternative(value) {
      console.log("event_value", value);

      this.Customer.alternative = value;
      this.$v.Customer.alternative.$touch();
    },

    /**
     * uodate
     */
    setEmail(value) {
      console.log("event_value", value);

      this.Customer.email = value;
      this.$v.Customer.email.$touch();
    },

    /**
     * uodate
     */
    setStreetAddress(value) {
      console.log("event_value", value);

      this.Customer.street_address = value;
      this.$v.Customer.street_address.$touch();
    },

    /**
     * uodate
     */
    setApartment(value) {
      console.log("event_value", value);

      this.Customer.apartment = value;
      this.$v.Customer.apartment.$touch();
    },

    /**
     * uodate
     */
    setCity(value) {
      console.log("event_value", value);

      this.Customer.city = value;
      this.$v.Customer.city.$touch();
    },

    /**
     * uodate
     */
    setZip(value) {
      console.log("event_value", value);
      this.Customer.zip = value;
      this.$v.Customer.zip.$touch();
    },

    /**
     * redirecttoAddCustomer
     */
    redirectToAddCustomer() {
      this.$router.push({
        name: "add-customer",
      });
    },

    /**
     * setItemAsActiveItem
     */
    setItemAsActiveItem(item_temp) {
        
        console.log("values", this.active_item, "mid", item_temp.customer_id);
        this.active_item = this.active_item == item_temp.customer_id ? "" : item_temp.customer_id;
        console.log("item_temp before setting", item_temp);

        if (this.active_item == "") {
          setTimeout(function(){

            this.Customer["firstname"]='';
            this.Customer["lastname"]='';
            this.Customer["spouce_f_name"]='';
            this.Customer["spouce_l_name"]='';
            this.Customer["cell_phone"]='';
            this.Customer["alternative"]='';
            this.Customer["should_contact"]='';
            this.Customer["email"]='';
            this.Customer["street_address"]='';
            this.Customer["apartment"]='';
            this.Customer["city"]='';
            this.Customer["zip"]='';

        }, 2000);  
        
        } else {
            // this.temp_Customer=itm;
            this.Customer = item_temp;
        }
            // console.log("item now;;", item_temp);
    //      console.log("customer after setting;[[[", this.Customer);
            console.log("customer after setting;", this.Customer);
            console.log('original data',this.resultQuery.data)
    },

    /**
     * updateCustomer
     */
    updateCustomer() {
      this.setLoader(true);
      let token = localStorage.getItem("token");
      axios
        .post(
          "/api/update-customer",
          {
            customer: this.Customer,
          },
          {
            headers: {
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => {
          if (response) {
            this.setLoader(false);
            this.showAlert([
              response.data.response_header.response_message,
              "success",
            ]);
            this.getCustomers();
            this.active_item = "";
          }
        })
        .catch((error) => {
          this.setLoader(false);
          if (error.response) {
            if (error.response.data.errors) {
              let msg =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.showAlert([msg, "danger"]);
            } else if (error.response.data.response_header.response_message) {
              this.showAlert([
                error.response.data.response_header.response_message,
                "danger",
              ]);
            }
          } else {
            this.showAlert([error, "danger"]);
          }
        });
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
          console.log(response.data);
          var customers = response.data.data;
          this.customers = customers;
          this.setLoader(false);
          console.log(this.customers);
        });
    },
  },
};
</script>
<style scoped>
.socialImg {
  width: 20px !important;
}
.table_arrow {
  position: absolute;
  right: 20px;
  top: 20px;
  z-index: 2;
}
.retail_price_inner .retail_price_col_head {
  padding: 10px 0px;
  border: 0px;
}
.retail_price_col {
  padding: 0px 10px;
}
.retail_price_col_info p {
  padding: 0px;
}
.retail_field {
  text-align: left;
}
.pending_watches_list ul li {
  border-bottom: 1px solid #fff;
}
.pending_watches_list ul li:first-child {
  border-top: 1px solid #fff;
}

.pending_watches_list .retail_price_col_info {
  padding: 10px 10px;
}

.pending_watches_list {
  padding-bottom: 20px;
}

.retail_field input {
  text-align: left;
}

.retail_price_col_head strong b {
  font-weight: normal;
}
</style>
