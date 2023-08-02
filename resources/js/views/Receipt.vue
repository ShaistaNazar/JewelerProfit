<template>
  <div class="container pb-5">
    <div class="envelop_container">
      <div class="row">
        <div class="col-lg-12 pb-3 text-left">
          <b-button class="round-border backBtn" @click="$router.go(-1)">
            <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
          </b-button>
        </div>

        <div class="col-md-6">
          <div id="printReciept1">
            <div id="invoice-POS" style="background: #fff">
              <div class="reciept_table_col settlogo">
                <span class="reciept_img">
                  <custom-image
                    src="assets/logo.png"
                    alt="logo"
                    class_to_pass="mx-auto d-block"
                  />
                </span>
              </div>

              <div class="repair_reciept">
                <div class="repair_reciept_table">
                  <div class="repair_reciept_table_head">
                    <div class="reciept_table_col w55">
                      <h5>{{ $store.state.dataStore.shop.shop_name }}</h5>
                    </div>
                    <div class="reciept_table_col w45">
                      <h5>Repair Receipt</h5>
                    </div>
                  </div>

                  <div class="repair_reciept_table_list">
                    <ul>
                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w55">
                            <p>{{ $store.state.dataStore.shop.apartment }}</p>
                            <p>
                              {{ $store.state.dataStore.shop.street_address }}
                            </p>
                            <p>{{ $store.state.dataStore.shop.city }}</p>
                            <p>{{ $store.state.dataStore.shop.contact_no }}</p>
                            <p>www.jewelerProfit.com</p>
                          </div>
                          <div class="reciept_table_col w45">
                            <p>
                              <small>Envelope #</small>
                              {{
                                $store.state.dataStore.envelope_numbers[
                                  $store.state.dataStore
                                    .selected_envelope_number
                                ]
                              }}
                            </p>
                            <p></p>
                            <p></p>
                            <p>
                              <small>Take-in date: {{ message }}</small>
                              {{ minutes }}
                            </p>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w55">
                            <p>
                              <small>Customer:</small>
                              {{
                                $store.state.dataStore.customer_details[
                                  "customer_id"
                                ]
                              }}
                            </p>
                            <p>
                              {{
                                $store.state.dataStore.customer_details[
                                  "firstname"
                                ]
                              }}
                              {{
                                $store.state.dataStore.customer_details[
                                  "lastname"
                                ]
                              }}
                            </p>
                            <p>
                              {{
                                $store.state.dataStore.customer_details[
                                  "street_address"
                                ]
                              }}
                              {{
                                $store.state.dataStore.customer_details[
                                  "apartment"
                                ]
                              }}
                            </p>
                            <p>
                              {{
                                $store.state.dataStore.customer_details["city"]
                              }}
                              {{
                                $store.state.dataStore.customer_details["zip"]
                              }}
                            </p>
                            <p>
                              <small>H:</small>
                              {{
                                $store.state.dataStore.customer_details[
                                  "home_phone"
                                ]
                              }}
                            </p>
                            <p>
                              <small>Cell:</small>
                              {{
                                $store.state.dataStore.customer_details[
                                  "cell_phone"
                                ]
                              }}
                            </p>
                            <p>
                              {{
                                $store.state.dataStore.customer_details[
                                  "primary_email"
                                ]
                              }}
                            </p>
                          </div>
                          <div class="reciept_table_col w45">
                            <p>
                              <small>You were assisted by:</small
                              >{{ sale_person_name }}
                            </p>
                            <span class="reciept_img">
                              <!-- <custom-image v-if="0 in $store.state.dataStore.descriptionOfItem.photos" :src="$store.state.dataStore.descriptionOfItem.photos[0]"  alt="error in showing item picture" class_to_pass="mx-auto d-block"/> 
                            <custom-image v-if="1 in $store.state.dataStore.descriptionOfItem.photos" :src="$store.state.dataStore.descriptionOfItem.photos[1]"  alt="error in showing item picture" class_to_pass="mx-auto d-block"/> 
                            <custom-image v-if="2 in $store.state.dataStore.descriptionOfItem.photos" :src="$store.state.dataStore.descriptionOfItem.photos[2]"  alt="error in showing item picture" class_to_pass="mx-auto d-block"/> -->
                            </span>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div
                            class="reciept_table_col"
                            v-if="
                              Object.keys(
                                $store.state.dataStore.items_price_detail
                              ).includes('0')
                            "
                          >
                            <p>Your items we are repairing:</p>
                            <!-- <p v-for="chapter_selection in Object.keys($store.state.dataStore.selections)" :key="chapter_selection"> 
                            <strong style="text-decoration-line: underline;text-decoration-style: double;">Chapter {{$store.state.dataStore.main_chapter}}</strong>
                              <span v-for="(procedure,procedure_index) in Object.values($store.state.dataStore.selections[$store.state.dataStore.main_chapter])" :key="procedure_index">
                              procedure {{procedure_index + 1}}:
                              <span v-for="(option,option_key) in procedure['options']" :key="option_key">
                                <span style="text-decoration:underline">{{option_key}}</span>
                                <strong>({{option}})</strong>
                              </span>
                            </span>  -->

                            <div
                              v-for="(
                                chapter_selection, envelope_index
                              ) in $store.state.dataStore.items_price_detail[
                                $store.state.dataStore.no_of_generated_envelopes
                              ][
                                $store.state.dataStore.envelope_numbers[
                                  $store.state.dataStore
                                    .selected_envelope_number
                                ]
                              ]"
                              :key="envelope_index"
                            >
                              <div
                                v-if="envelope_index !== 'receipt_generated'"
                              >
                                <span class="w-100 d-block">
                                  Chapter {{ envelope_index }}
                                </span>

                                <!-- <span v-if="chapter_selection.receipt_generated == false">  -->
                                <span
                                  class="d-block"
                                  v-for="(
                                    procedure, procedure_index
                                  ) in chapter_selection"
                                  :key="procedure_index"
                                >
                                  <strong>
                                    {{ procedure["major_item"] }}
                                  </strong>
                                  (<span
                                    class="text-underline text-underline-success"
                                  >
                                  </span>
                                  having geller SKU
                                  <strong>{{ procedure["geller_sku"] }}</strong
                                  >) priced
                                  <strong class="w-100">
                                    (${{ procedure["total"] }}):
                                  </strong>

                                  <span>
                                    {{ procedure["item_description"] }}
                                  </span>
                                </span>
                              </div>
                              <!-- </span>  -->
                            </div>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w65">
                            <h5>Item Price</h5>
                          </div>
                          <div class="reciept_table_col w35 w-100">
                            <strong
                              v-if="
                                envelopeTotal['estimated_amount'] &&
                                envelopeTotal['estimated_amount'] > 0
                              "
                            >
                              ${{ envelopeTotal["total"] }} to ${{
                                envelopeTotal["total_with_estimated_amount"]
                              }}
                            </strong>
                            <strong v-else>
                              ${{ envelopeTotal["total"] }}
                            </strong>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w65">
                            <h5>Sales tax</h5>
                          </div>
                          <div class="reciept_table_col w35">
                            <strong> ${{ envelopeTotal["sales_tax"] }}</strong>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w65">
                            <h5>Grand Total</h5>
                          </div>
                          <div class="reciept_table_col w35">
                            <strong
                              v-if="
                                envelopeTotal['estimated_amount'] &&
                                envelopeTotal['estimated_amount'] > 0
                              "
                            >
                              ${{ envelopeTotal["total_with_sales_tax"] }} to
                              ${{
                                envelopeTotal[
                                  "total_with_sales_tax_along_estimated_amount"
                                ]
                              }}
                            </strong>
                            <strong v-else>
                              ${{ envelopeTotal["total_with_sales_tax"] }}
                            </strong>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="barcode_info">
                <barcode
                  v-bind:value="barcodeValue"
                  height="30"
                  width="1.5"
                  :display-value="false"
                >
                  Show this if the rendering fails.
                </barcode>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div id="printReciept2">
            <div id="invoice-POS" style="background: #fff">
              <div class="reciept_table_col settlogo">
                <span class="reciept_img">
                  <custom-image
                    src="assets/logo.png"
                    alt="logo"
                    class_to_pass="mx-auto d-block"
                  />
                </span>
              </div>

              <div class="repair_reciept">
                <div class="repair_reciept_table">
                  <div class="repair_reciept_table_head">
                    <div class="reciept_table_col w55">
                      <h5>{{ $store.state.dataStore.shop.shop_name }}</h5>
                    </div>
                    <div class="reciept_table_col w45">
                      <h5>Store Copy</h5>
                    </div>
                  </div>

                  <div class="repair_reciept_table_list">
                    <ul>
                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w55">
                            <p>{{ $store.state.dataStore.shop.apartment }}</p>
                            <p>
                              {{ $store.state.dataStore.shop.street_address }}
                            </p>
                            <p>{{ $store.state.dataStore.shop.city }}</p>
                            <p>{{ $store.state.dataStore.shop.contact_no }}</p>
                            <p>www.jewelerProfit.com</p>
                          </div>
                          <div class="reciept_table_col w45">
                            <p>
                              <small>Envelope #</small>
                              {{
                                $store.state.dataStore.envelope_numbers[
                                  $store.state.dataStore
                                    .selected_envelope_number
                                ]
                              }}
                            </p>
                            <p></p>
                            <p></p>
                            <p>
                              <small>Take-in date: {{ message }}</small>
                              {{ minutes }}
                            </p>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w55">
                            <p>
                              <small>Customer:</small>
                              {{
                                $store.state.dataStore.customer_details[
                                  "customer_id"
                                ]
                              }}
                            </p>
                            <p>
                              {{
                                $store.state.dataStore.customer_details[
                                  "firstname"
                                ]
                              }}
                              {{
                                $store.state.dataStore.customer_details[
                                  "lastname"
                                ]
                              }}
                            </p>
                            <p>
                              {{
                                $store.state.dataStore.customer_details[
                                  "street_address"
                                ]
                              }}
                              {{
                                $store.state.dataStore.customer_details[
                                  "apartment"
                                ]
                              }}
                            </p>
                            <p>
                              {{
                                $store.state.dataStore.customer_details["city"]
                              }}
                              {{
                                $store.state.dataStore.customer_details["zip"]
                              }}
                            </p>
                            <p>
                              <small>H:</small>
                              {{
                                $store.state.dataStore.customer_details[
                                  "home_phone"
                                ]
                              }}
                            </p>
                            <p>
                              <small>Cell:</small>
                              {{
                                $store.state.dataStore.customer_details[
                                  "cell_phone"
                                ]
                              }}
                            </p>
                            <p>
                              {{
                                $store.state.dataStore.customer_details[
                                  "primary_email"
                                ]
                              }}
                            </p>
                          </div>
                          <div class="reciept_table_col w45">
                            <p>
                              <small>You were assisted by:</small
                              >{{ sale_person_name }}
                            </p>
                            <span class="reciept_img">
                              <!-- <custom-image v-if="0 in $store.state.dataStore.descriptionOfItem.photos" :src="$store.state.dataStore.descriptionOfItem.photos[0]"  alt="error in showing item picture" class_to_pass="mx-auto d-block"/> 
                            <custom-image v-if="1 in $store.state.dataStore.descriptionOfItem.photos" :src="$store.state.dataStore.descriptionOfItem.photos[1]"  alt="error in showing item picture" class_to_pass="mx-auto d-block"/> 
                            <custom-image v-if="2 in $store.state.dataStore.descriptionOfItem.photos" :src="$store.state.dataStore.descriptionOfItem.photos[2]"  alt="error in showing item picture" class_to_pass="mx-auto d-block"/> -->
                            </span>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div
                            class="reciept_table_col"
                            v-if="
                              Object.keys(
                                $store.state.dataStore.items_price_detail
                              ).includes('0')
                            "
                          >
                            <p>Your items we are repairing:</p>
                            <!-- <p v-for="chapter_selection in Object.keys($store.state.dataStore.selections)" :key="chapter_selection"> 
                            <strong style="text-decoration-line: underline;text-decoration-style: double;">Chapter {{$store.state.dataStore.main_chapter}}</strong>
                              <span v-for="(procedure,procedure_index) in Object.values($store.state.dataStore.selections[$store.state.dataStore.main_chapter])" :key="procedure_index">
                              procedure {{procedure_index + 1}}:
                              <span v-for="(option,option_key) in procedure['options']" :key="option_key">
                                <span style="text-decoration:underline">{{option_key}}</span>
                                <strong>({{option}})</strong>
                              </span>
                            </span>  -->

                            <div
                              v-for="(
                                chapter_selection, envelope_index
                              ) in $store.state.dataStore.items_price_detail[
                                $store.state.dataStore.no_of_generated_envelopes
                              ][
                                $store.state.dataStore.envelope_numbers[
                                  $store.state.dataStore
                                    .selected_envelope_number
                                ]
                              ]"
                              :key="envelope_index"
                            >
                              <div
                                v-if="envelope_index !== 'receipt_generated'"
                              >
                                <span class="w-100 d-block">
                                  Chapter {{ envelope_index }}
                                </span>

                                <!-- <span v-if="chapter_selection.receipt_generated == false">  -->
                                <span
                                  class="d-block"
                                  v-for="(
                                    procedure, procedure_index
                                  ) in chapter_selection"
                                  :key="procedure_index"
                                >
                                  <strong>
                                    {{ procedure["major_item"] }}
                                  </strong>
                                  (<span
                                    class="text-underline text-underline-success"
                                  >
                                  </span>
                                  having geller SKU
                                  <strong>{{ procedure["geller_sku"] }}</strong
                                  >) priced
                                  <strong class="w-100">
                                    (${{ procedure["total"] }}):
                                  </strong>

                                  <span>
                                    {{ procedure["item_description"] }}
                                  </span>
                                </span>
                              </div>
                              <!-- </span>  -->
                            </div>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w65">
                            <h5>Item Price</h5>
                          </div>
                          <div class="reciept_table_col w35 w-100">
                            <strong
                              v-if="
                                envelopeTotal['estimated_amount'] &&
                                envelopeTotal['estimated_amount'] > 0
                              "
                            >
                              ${{ envelopeTotal["total"] }} to ${{
                                envelopeTotal["total_with_estimated_amount"]
                              }}
                            </strong>
                            <strong v-else>
                              ${{ envelopeTotal["total"] }}
                            </strong>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w65">
                            <h5>Sales tax</h5>
                          </div>
                          <div class="reciept_table_col w35">
                            <strong> ${{ envelopeTotal["sales_tax"] }}</strong>
                          </div>
                        </div>
                      </li>

                      <li>
                        <div class="repair_reciept_table_head">
                          <div class="reciept_table_col w65">
                            <h5>Grand Total</h5>
                          </div>
                          <div class="reciept_table_col w35">
                            <strong
                              v-if="
                                envelopeTotal['estimated_amount'] &&
                                envelopeTotal['estimated_amount'] > 0
                              "
                            >
                              ${{ envelopeTotal["total_with_sales_tax"] }} to
                              ${{
                                envelopeTotal[
                                  "total_with_sales_tax_along_estimated_amount"
                                ]
                              }}
                            </strong>
                            <strong v-else>
                              ${{ envelopeTotal["total_with_sales_tax"] }}
                            </strong>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="barcode_info">
                <barcode
                  v-bind:value="barcodeValue"
                  height="30"
                  width="1.5"
                  :display-value="false"
                >
                  Show this if the rendering fails.
                </barcode>
              </div>
            </div>
          </div>


          <div class="pt-4 text-center reciepetBttns">
            <!-- <button data-v-5f61a64d="" type="button" class="btn round-border shadow-lg btn-warning mx-1"  @click="startCycle()"> Cancel </button> -->
            <!-- <button data-v-5f61a64d="" type="button" class="btn round-border shadow-lg btn-warning mx-1"  @click="startCycle()"> Start Cycle </button> -->
          </div>
        </div>
        <div class="col-md-12">
          <div class="pt-4 text-center reciepetBttns w-100">
            <b-form-textarea
              class="sett_textarea round-border p-4 w-100 mb-3"
              placeholder="Mark The Envelope"
              name="internal_envelope"
              v-model="notes"
            ></b-form-textarea>

            <button
              data-v-5f61a64d=""
              type="button"
              v-print="printObj"
              class="btn round-border shadow-lg btn-warning mx-1"
            >
              Confirm Envelope and Print
            </button>
            <!-- <button data-v-5f61a64d="" type="button" class="btn round-border shadow-lg btn-warning mx-1" disabled> Email to Customer </button> -->
          </div>
        </div>
      </div>
    </div>

    <div class="myModel" style="display: block">
      <div>
        <b-modal
          id="modal-1"
          no-close-on-esc
          no-close-on-backdrop
          hide-header-close
          header-border-variant="primary"
          footer-border-variant="primary"
          header-bg-variant="primary"
          footer-bg-variant="primary"
          body-bg-variant="primary"
          centered
          title="Email to Customer"
        >
          <div class="">
            <div class="myForn">
              <input
                type="text"
                value=""
                placeholder="Email sent"
                class="round-border form-control"
              />
            </div>
          </div>

          <template #modal-footer>
            <div class="w-100">
              <default-button
                variant="warning"
                text="  Send  "
                class="btn float-right round-border shadow-lg btn-success mb-3"
                @onSubmit="saveStaffGivenDescription()"
              />
            </div>
          </template>
        </b-modal>
      </div>
    </div>
  </div>
</template>
 
<script>
import VueBarcode from "vue-barcode";
import { mapGetters, mapActions } from "vuex";
import print from "vue-print-nb";

export default {
  components: {
    barcode: VueBarcode,
  },
  directives: {
    print,
  },
  mounted() {
    var storageSize = Math.round(JSON.stringify(localStorage).length / 1024);
    console.log(storageSize);
    this.getdateTime();
    this.getSalePerson();
    // this.getDescription();
    this.getSalesTax();
  },
  data() {
    return {
      barcodeValue:
        0 in this.$store.state.dataStore.items_price_detail
          ? this.$store.state.dataStore.items_price_detail[0][
              this.$store.state.dataStore.selected_envelope_number
            ]
          : "Error",
      message: "dateTime",
      minutes: "",
      sale_person_name: "",
      sales_tax: 0,
      previous_envelope_is_done: false,
      notes: "",
      printObj: {
        id: "printReciept2",
        popTitle: "Receipt by GellersBlueBook",
        openCallback(vue) {
          new Promise(function (resolve, reject) {
            vue.$store.commit("dataStore/setReceiptGeneratedToEnvelope");
            resolve(true);
            return true;
          }).then(function (result) {
            vue.addEnvelopeDetails();
            vue.previous_envelope_is_done = true;
          });
        },
      },
    };
  },
  computed: {
    envelopeTotal() {
      var price_obj = {};
      var envelope_number =
        this.$store.state.dataStore.envelope_numbers[
          this.$store.state.dataStore.selected_envelope_number
        ];
      var no_of_generated_envelopes =
        this.$store.state.dataStore.no_of_generated_envelopes;
      var items_price_detail = this.$store.state.dataStore.items_price_detail;
      var sum = 0;
      var estimated_amount = 0;
      // console.log(Object.keys(this.$store.state.dataStore.items_price_detail),'keys',no_of_generated_envelopes);
      if (Object.keys(this.$store.state.dataStore.items_price_detail).includes(no_of_generated_envelopes.toString())) {
        // console.log("envelope_number", envelope_number);
        for (let item in items_price_detail[no_of_generated_envelopes][envelope_number]) {
          for (let nestedItem in items_price_detail[no_of_generated_envelopes][envelope_number][item]) {
 
            console.log('nested item',items_price_detail[no_of_generated_envelopes][envelope_number][item][nestedItem]);

            sum +=Number(items_price_detail[no_of_generated_envelopes][envelope_number][item][nestedItem]["total"]);
            estimated_amount +=Number(items_price_detail[no_of_generated_envelopes][envelope_number][item][nestedItem]["estimation_to_add"]);
          }
        }
      }

      console.log("estimation to add", estimated_amount);
      price_obj["total"] = Math.round(sum);
      price_obj["sales_tax"] = this.sales_tax;
      price_obj["estimated_amount"] = Math.round(estimated_amount);
      price_obj["total_with_estimated_amount"] = Math.round(sum) + price_obj["estimated_amount"];
      price_obj["total_with_sales_tax"] = price_obj["total"] + this.sales_tax;
      price_obj["total_with_sales_tax_along_estimated_amount"] =
      price_obj["total"] + price_obj["estimated_amount"] + this.sales_tax;
      return price_obj;

    },
  },
  methods: {
    ...mapActions("dataStore", [
      "resetState",
      "incrementEnvelopeNumber",
      "setLoader",
    ]),
    addEnvelopeDetails() {
      var token = localStorage.getItem("token");
      axios
        .post(
          "/api/add-envelope-details",
          {
            envelope_id:
              this.$store.state.dataStore.envelope_numbers[
                this.$store.state.dataStore.selected_envelope_number
              ],
            customer_number:
              this.$store.state.dataStore.customer_details["customer_id"],
            sale_person_id: this.$store.state.dataStore.sale_person_id,
            notes: this.notes,
            total: this.envelopeTotal["total"],
            total_with_sales_tax: this.envelopeTotal["total_with_sales_tax"],
          },
          {
            headers: {
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => {
          this.setLoader(false);
          if (
            response.data.response_header.response_code == 200 ||
            response.data.response_header.response_code == 202
          ) {
            this.$bvModal.hide("estimated-modal");
            if (response.data.response_header.response_code == 202) {
              this.set_estimate_only = true;
            }
          }
        })
        .catch((error) => {
          this.setLoader(false);
        });
    },
    getdateTime() {
      var date = new Date().toJSON();
      var dateTimeNewFormat = date.slice(0, 10).replace(/-/g, "/");
      this.message = dateTimeNewFormat;
      this.minutes = date.slice(11, 19);
    },
    startCycle() {
      sessionStorage.clear();
      this.resetState();
      this.$router.push("/").catch();
    },
    getSalePerson() {
      axios
        .get(
          "/api/get-sale-person-of-shop?id=" +
            this.$store.state.dataStore.sale_person_id,
          {},
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        )
        .then((response) => {
          this.sale_person_name = response.data.data.fullname;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getSalesTax() {
      axios
        .get(
          "/api/get-sales-tax",
          {},
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        )
        .then((response) => {
          this.sales_tax = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
     
<style scoped>
ul,
li {
  padding: 0px;
  margin: 0px;
}
li {
  list-style: none;
}

#invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 10mm 2mm 15mm;
  color: #000 !important;
  background: #fff;
}

.repair_reciept {
  border: 1px solid #000;
}

.repair_reciept_table {
  width: 100%;
}
.repair_reciept_table_head {
  width: 100%;
  display: table;
}
.reciept_table_col {
  display: table-cell;
  vertical-align: top;
  padding: 5px 6px;
  border-right: 1px solid #000;
  border-bottom: 1px solid #000;
}
.reciept_table_col:last-child {
  border-right: 0px;
}

.reciept_table_col h5 {
  font-size: 13px;
  margin-bottom: 0px;
  padding: 3px 0px;
  font-weight: bold;
}
.reciept_table_col p {
  font-size: 12px;
  margin-bottom: 2px;
  min-height: 18px;
}
.reciept_table_col p small {
  font-size: 12px;
  margin-bottom: 0px;
  margin-right: 5px;
}

.w55 {
  width: 55%;
}
.w45 {
  width: 45%;
}
.w65 {
  width: 65%;
}
.w35 {
  width: 35%;
}

.repair_reciept_table_list ul li:last-child .reciept_table_col {
  border-bottom: 0px;
}

.barcode_info {
  padding-top: 15px;
  padding-left: 35%;
}

.barcode_info barcode {
  display: block;
  margin: auto;
}

.encode > img {
  width: 90px !important;
  display: block;
}

.reciept_img {
  max-width: 100%;
  display: flex;
  flex-wrap: wrap;
  margin-top: 10px;
}
.reciept_img img {
  width: 100%;
  display: block;
  max-width: 55px;
  margin-right: 10px;
  margin-bottom: 10px !important;
  max-height: 30px;
  object-fit: cover;
}

.settlogo {
  border: 0px !important;
  display: block !important;
  margin-bottom: 20px !important;
}
.settlogo .reciept_img {
  margin: auto;
  max-width: 100% !important;
  margin-bottom: 0px !important;
}
.settlogo .reciept_img img {
  max-width: 125px !important;
  margin-right: 0px !important;
  margin: auto !important;
  max-height: 100% !important;
  margin-bottom: 0px !important;
}
</style>