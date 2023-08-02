<template>
  <div class="container mx-auto">
    <div class="main_dashboard">
      <custom-alert
        v-if="showDismissibleAlert"
        :showDismissibleAlert="showDismissibleAlert"
        :msg="alertMsg"
        :variant="variant"
      />
      <div class="container">
        <div class="row pb-4 align-items-center">
          <div class="col-lg-8 col-md-8">
            <div class="shank_tittle">
              <b-button class="round-border backBtn" @click="$router.go(-1)">
                <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
              </b-button>
              <h5 class="m-0 p-0 ml-3">Sort Box</h5>
            </div>
          </div>
          <!-- {{selected_envelopes}} -->
          <div class="col-lg-4 col-md-4">
            <div
              class="mySelect_outer d-flex justify-content-end align-items-center"
            >
              <b-button
                class="btn-success"
                :disabled="ifnoneSelected"
                v-b-modal.location-modal
                >Move to Locations</b-button
              >
            </div>
          </div>
        </div>

        <div class="col-lg-12 col-md-12 p-0 pb-4 align-items-center">
            <div class="form-group has-search fa_search col-lg-12 col-md-12 justify-content-center">
            <input
            type="text"
            class="form-control round-border p-4"
            placeholder="Search by envelope id"
            v-model="searchQuery"
            @keyup="getSortBox()"
            />
            <b><b-icon icon="search"></b-icon></b>
            </div>
        </div> 

        <div class="my_tableOuter">
          <div class="my_tableInner">
            <div class="jobsListing_section">
              <ul>
                <li>
                  <div class="location_bg">
                    <div class="jobsListing_info">
                      <div
                        class="row flex-nowrap align-items-center text-warning"
                      >
                        <div>
                          <!-- <div class="jobsListing_col">
                            <strong>Envelope ID</strong>
                          </div> -->
                        </div>
                        <div>
                          <div class="jobsListing_col">
                            <strong>Envelope ID</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong>Customer ID</strong>
                          </div>
                        </div>
                        <div>
                          <div class="jobsListing_col">
                            <strong>Notes</strong>
                          </div>
                        </div>
                        <div>
                          <div class="jobsListing_col">
                            <strong>Take In Date</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong>Total With Sales Tax</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong>Sale Person</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong>Envelope Details</strong>
                          </div>
                          <!-- <div class="sortBttn">
                                                <button class="btn btn-success" v-on:click="seen = !seen">Show Details</button>
                                            </div> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <!-- {{resultQuery}} -->
            <div class="jobsListing_section">
              <ul>
                <li
                  v-for="(envelope, envelope_index) in resultQuery.data"
                  :key="envelope_index"
                >
                  <!-- <div> -->

                  <div class="location_bg">
                    <div class="jobsListing_info">
                      <div class="row flex-nowrap align-items-center">
                        <div>
                          <label class="custom_checkbox">
                            <input
                              type="checkbox"
                              v-model="envelope.checked"
                              :id="'checkbox-' + envelope_index"
                            />
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div>
                          <div class="jobsListing_col">
                            <strong>{{ envelope.envelope_id }}</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong>{{ envelope.customer_number }}</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong>{{ envelope.notes }}</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong>{{ envelope.take_in_date }}</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong>{{
                              envelope.grand_total_with_sales_tax
                            }}</strong>
                          </div>
                        </div>

                        <div>
                          <div class="jobsListing_col">
                            <strong v-if="envelope.sale_person">{{
                              envelope.sale_person.fullname
                            }}</strong>
                          </div>
                        </div>

                        <div>
                          <div class="sortBttn">
                            <button
                              class="btn btn-success"
                              v-if="seen !== envelope.envelope_id"
                              v-on:click="seen = envelope.envelope_id"
                            >
                              Show Details
                            </button>
                            <button
                              class="btn btn-success"
                              v-if="seen == envelope.envelope_id"
                              v-on:click="seen = ''"
                            >
                              Hide Details
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="location_bg mt-4"
                    v-if="seen == envelope.envelope_id"
                  >
                    <div class="jobDetail_page">
                      <div class="jobDetail_info">
                        <table class="table">
                          <tbody>
                            <tr
                              v-for="(
                                price_details, price_details_index
                              ) in envelope.sort_box_job_history.price_chart"
                              :key="price_details_index"
                            >
                              <!-- {{price_details}} == {{price_details_index}} -->
                              <td class="text-success">
                                <strong>
                                  {{ price_details_index }}
                                </strong>
                              </td>
                              <td width="350">
                                <strong class="text-success">Geller SKU</strong>
                              </td>
                              <td>
                                <strong>{{ price_details.geller_sku }}</strong>
                              </td>
                              <td width="350">
                                <strong class="text-success">Major Item</strong>
                              </td>
                              <td>
                                <strong>{{ price_details.major_item }}</strong>
                              </td>
                              <td width="350">
                                <strong class="text-success">Total</strong>
                              </td>
                              <td>
                                <strong>{{ price_details.total }}</strong>
                              </td>
                            </tr>

                            <!-- <tr>
                                                    <td width="350"><strong>Major Item</strong></td>
                                                    <td><strong>{{price_details.major_item}}</strong></td> 
                                                </tr>

                                                <tr>
                                                    <td width="350"><strong>Total</strong></td>
                                                    <td><strong>{{price_details.total}}</strong></td> 
                                                </tr> -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- adjust amout popup  -->
    <div class="myModel">
      <div>
        <b-modal
          id="location-modal"
          header-border-variant="primary"
          footer-border-variant="primary"
          body-bg-variant="primary"
          header-bg-variant="primary"
          footer-bg-variant="primary"
          hide-footer
          centered
          title="Move Envelope to other location"
        >
          <template>
            <div class="JwereList">
              <h6>Move To Locations</h6>
              <div class="">
                <b-form-group>
                  <b-form-radio-group
                    :options="rush_options"
                    name="radio-stacked-rush"
                    v-model="selected_location"
                  ></b-form-radio-group>
                </b-form-group>
              </div>
            </div>

            <div class="assign_Jweler myForn">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div
                    class="assign_Jweler_form mb-4"
                    v-if="selected_location == 'jeweler_box'"
                  >
                    <h6 class="pb-2">Select Jeweler please</h6>
                    <div class="dropdown myDropdown">
                      <b-dropdown
                        id="dropdown-1"
                        text="Choose Jeweler"
                        class=""
                      >
                        <b-dropdown-item
                          @click="selectJeweler(sale_person)"
                          v-for="sale_person in jewelers"
                          :key="sale_person.id"
                        >
                          <span>{{ sale_person.text }}</span></b-dropdown-item
                        >
                      </b-dropdown>
                    </div>

                    <div>
                      <b-form-datepicker
                      id="date-picker-label"
                      v-model="expected_from_jeweler"
                      class="round-border p-2 text-left"
                    ></b-form-datepicker>
                  </div>
                  </div>
                  <!-- <div class="assign_Jweler_form mb-1">
                             <span v-if="!isLocationSelected && !isJewelerSelected" class="text-danger">Please select a location or a jeweler</span>
                            <span v-else-if="isLocationSelected && isJewelerSelected" 
                            class="text-danger">Please select only one</span>
                        </div> -->
                  <div
                    class="assign_Jweler_form addNewCustom mb-4"
                    v-if="selected_location == 'order_box'"
                  >
                    <h6 class="pb-2">Select Expected Arrival Date</h6>
                    <div class="form-group">
                      <b-form-datepicker
                        id="date-picker-label"
                        v-model="arrival_date"
                        class="round-border p-2 text-left"
                      ></b-form-datepicker>
                    </div>
                  </div>
                  <div
                    class="assign_Jweler_form addNewCustom mb-4"
                    v-if="selected_location == 'order_box'"
                  >
                    <h6 class="pb-2">
                      PLease select whome you want to give order to
                    </h6>
                    <div class="form-group">
                      <div class="dropdown myDropdown">
                        <b-dropdown
                          id="dropdown-1"
                          text="Choose Vendor"
                          class=""
                        >
                          <b-dropdown-item
                            @click="selectVendor(sale_person)"
                            v-for="(sale_person, index) in vendors"
                            :key="index"
                          >
                            <span>{{ sale_person.text }}</span></b-dropdown-item
                          >
                        </b-dropdown>
                      </div>
                    </div>
                  </div>

                  <div
                    class="assign_Jweler_form addNewCustom mb-4"
                    v-if="selected_location == 'finished_box'"
                  >
                    <h6 class="pb-2">Job Finished Date</h6>
                    <div class="form-group">
                      <b-form-datepicker
                        id="date-picker-label"
                        v-model="finished_date"
                        class="round-border p-2 text-left"
                      ></b-form-datepicker>
                    </div>
                  </div>

                  <div class="assign_Jweler_form mb-4">
                    <h6 class="pb-2">Notes</h6>
                    <div class="form-group">
                      <b-form-textarea
                        class="sett_textarea round-border p-4"
                        placeholder="Add internal Description"
                        name="stones_quality_description"
                        v-model="envelope_notes"
                      >
                      </b-form-textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="sortBttn text-center pt-3">
              <button
                class="btn btn-success round-border"
                @click="moveEnvelope()"
              >
                Move Envelopes
              </button>
            </div>
          </template>
        </b-modal>
      </div>
    </div>
    <div class="text-center sett_pagintation pb-3 m-5">
      <pagination
        class="justify-content-center"
        :data="resultQuery"
        @pagination-change-page="getSortBox"
      ></pagination>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Loading from "vue-loading-overlay";

/**
 * Vuelidate items
 */

import {} from "vuelidate/lib/validators";
import Input from "../../components/Global/Input.vue";
import Button from "../../components/Global/Button.vue";

export default {
  components: {
    loading: Loading,
    Input,
    Button,
  },

  mounted() {
    this.getSortBox();
    this.getJewelers();
    this.getVendors();
  },
  computed: {
    ifnoneSelected() {
      var checkedKeys = [];
      for (const key in this.sort_box.data) {
        if (this.sort_box.data[key].checked === true) {
          checkedKeys.push(key);
        }
      }
      if (checkedKeys.length < 1) {
        return true;
      } else {
        return false;
      }
    },
    isLocationSelected() {
      return this.selected_location !== null;
    },

    isJewelerSelected() {
      const isJewelerSelected = this.selected_jeweler !== null;
      const isLocationSelected = this.isLocationSelected;
      if (isLocationSelected && isJewelerSelected) {
        this.selected_location = null;
        this.selected_jeweler = null;
        this.$nextTick(() => {
          // Wait for next DOM update
          this.isLocationSelected; // Update the value of isLocationSelected
        });
        return false;
      }
      return isJewelerSelected || !isLocationSelected;
    },
    resultQuery() {
      return this.sort_box;
    },
  },
  // watch: {
  //     selected_location(newVal, oldVal) {
  //     this.setMessage()
  //     },

  //     selected_jeweler(newVal, oldVal) {
  //     this.setMessage()
  //     }
  // },
  data() {
    return {
      searchQuery: "",
      showDismissibleAlert: false,
      master_price: {},
      seen: false,
      new_master_price: [],
      sort_box: [],
      rush_options: [
        { text: "Sort Box", value: 'sort_box' },
        { text: "Order Box", value: "order_box" },
        { text: "Hold Box", value: "hold_box" },
        // { text: 'Finished Box', value: 'finished_box' },
        // { text: 'Sort Box', value: true },
        { text: "Polish", value: "polish" },
        { text: "Cad Waxer", value: "cad_waxer" },
        { text: "Appraiser", value: "appraiser" },
        { text: 'Assign To Jeweler', value: 'jeweler_box' }, 

      ],
      promise_date: new Date(),
      envelope_notes: "",
      jewelers: [],
      selected_location: null,
      selected_envelopes: [],
      selected_jeweler: null,
      message: null,
      finished_date:new Date(),
    expected_from_jeweler:new Date(),

    };
  },
  validations: {},
  methods: {
    ...mapActions("dataStore", ["setLoader"]),

    selectJeweler(sale_person) {
      this.selected_jeweler = sale_person.value;
    },
    //  setMessage() {
    //     if (this.isLocationSelected && this.isJewelerSelected) {
    //         this.message = null
    //     } else if (!this.isLocationSelected && !this.isJewelerSelected) {
    //         this.message = 'Please select a location and a jeweler'
    //     } else {
    //         this.message = 'Please select a location and a jeweler'
    //     }
    // },
    moveEnvelope() {
      var checkedKeys = [];
      console.log("this.sort_box", this.sort_box);
      for (const key in this.sort_box.data) {
        console.log("checked or not", this.sort_box.data[key], key);
        if (this.sort_box.data[key].checked === true) {
          checkedKeys.push(this.sort_box.data[key].envelope_id);
        }
      }

      axios
        .post(
          `/api/change-envelopes-location`,
          {
            envelope_ids: checkedKeys,
            selected_location: this.selected_location,
            personal_notes: this.personal_notes,
            expected_date: this.promise_date,
            jeweler_id: this.selected_jeweler,
            envelope_notes: this.envelope_notes,
            finished_date:this.finished_date,
            from_location:'cad_waxer'

          },
          {}
        )
        .then((response) => {
          // this.isLoading = false;
          // var jewelers = response.data.data.data;
          this.getSortBox();
          this.$bvModal.hide("location-modal");
        });
    },
    getJewelers() {
      axios.get("/api/get-jewelers-of-shop").then((response) => {
        // this.isLoading = false;
        var jewelers = response.data.data.data;
        for (const jeweler of jewelers) {
          this.jewelers.push({ value: jeweler.id, text: jeweler.fullname });
        }
      });
    },
    getVendors()
    {
        this.setLoader(true);
        var token = localStorage.getItem("token");
        axios.get("/api/get-vendors-of-shop", {
        headers: {
            Authorization: "Bearer " + token,
        },
        }).then(response=>{
            // this.isLoading = false;
            var jewelers = response.data.data.data;
            for (const jeweler of jewelers) {
                this.vendors.push({'value': jeweler.id, "text": jeweler.name});          
            }  
        });
    },
    getSortBox(page = 1) {
      this.setLoader(true);
      var token = localStorage.getItem("token");
      axios
        .get(`/api/get-cad-waxer-box?filter=${this.searchQuery}&page=` + page, {
          headers: {
            Authorization: "Bearer " + token,
          },
        })
        .then((response) => {
            this.setLoader(false);
            this.sort_box = response.data.data.details;
            response.data.data.details.data.forEach(item => {
            this.$set(item, 'checked', false);
            });
            console.log('sort',response.data);
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
.socialImg {
  width: 20px !important;
}
</style>
