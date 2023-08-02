<template>
  <div class="">
    <div class="side_nav">
      <div
        class="d-flex flex-column px-4 pb-5"
        :set="(state = $store.state.dataStore)"
      >
        <div class="sidbarTittle">
          <h1 class="diamond">{{ tag }}</h1>
        </div>

        <div class="progress_report" v-if="Object.keys(state.envelope_numbers).length > 0">
          <div class="progress_head">
            <h3>Envelope Report</h3>
          </div>

          <div class="progress_data">
          <!-- <div class="sidebar_progresss">
            <progress-bar
              :options="options"
              :value="$store.state.dataStore.progress_percentage"
            />
          </div> -->
            <div
              class="my_customer"
              v-if="'firstname' in $store.state.dataStore.customer_details"
            >
              <h5 class="text-capitalize">
                <b class="" style="color: #28a745" v-on:click="isHidden = false"
                  ><b-icon icon="person-plus-fill" aria-hidden="true"></b-icon
                ></b>
                {{ $store.state.dataStore.customer_details["firstname"] }}
                {{ $store.state.dataStore.customer_details["lastname"] }}
                <button
                  class="trashFill text-warning"
                  @click="changeCustomer()"
                  v-if="
                    $store.state.dataStore.customer_details['primary_email']
                  "
                >
                  <b-icon icon="pencil-square" aria-hidden="true"></b-icon>
                </button>

                <div class="d-flex flex-column text-sm">
                  <div class="no_bottom_margin">
                    <small>
                      {{
                        $store.state.dataStore.customer_details["cell_phone"]
                      }}
                    </small>
                  </div>
                  <div>
                    <small>
                      {{
                        $store.state.dataStore.customer_details["primary_email"]
                      }}
                    </small>
                  </div>
                </div>
              </h5>
            </div>
            <div class="customer_list">
              <ul>
                <li>
                  <div class="customer_listData">
                    <div v-if="Object.keys(state.envelope_numbers).length > 0">
                      <span> no of envelopes: </span>
                      <span>
                        {{ Object.keys(state.envelope_numbers).length }}
                      </span>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="customer_listData">
                    <div v-if="Object.keys(state.envelope_numbers).length > 0">
                      <span>
                        current envelope number:
                        {{ state.no_of_generated_envelopes + 1 }}
                      </span>
                      <span>
                        envelope id:
                        {{
                          state.envelope_numbers[state.selected_envelope_number]
                        }}
                      </span>
                    </div>
                  </div>
                </li>
                <li  v-if="Object.keys(state.items_price_detail).length > 0">
                  <div class="customer_listData">
                      <span>
                        no of repairs:
                        <span v-if="state.main_chapter in 
                        state.items_price_detail[state.no_of_generated_envelopes]
                        [
                          state.envelope_numbers[
                            state.selected_envelope_number
                          ]
                        ]">
                        {{
                          Object.keys(
                            state.items_price_detail[
                              state.no_of_generated_envelopes
                            ][
                              state.envelope_numbers[
                                state.selected_envelope_number
                              ]
                            ][state.main_chapter]
                          ).length
                        }}
                        </span>
                        <span v-else>
                        0
                        </span>
                      </span>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- {{$store.state.dataStore.discarded_item_array}} -->
        <div
          class="infoText_nav"
          v-if="
            0 in $store.state.dataStore.discarded_item_array &&
            $route.query &&
            $store.state.dataStore.discarded_item_array[0] ==
              $route.query.chapter &&
            $store.state.dataStore.discarded_item_array[1] ==
              $route.query.procedure &&
            $store.state.dataStore.discarded_item_array[2]
          "
        >
          <p>
            This procedure doesnt support
            {{ $store.state.dataStore.discarded_item_array[2] }} Handling
          </p>
        </div>
      </div>
      <div class="nav_info">
        <ul>
          <li
            v-if="
              tag.includes('receipt') &&
              $store.state.dataStore.requested_envelopes > 1 &&
              allReceiptsGenerated < $store.state.dataStore.requested_envelopes
            "
          >
            <button @click="moveToNextEnvelope()">
              <b-icon
                class="text-warning mr-3"
                icon="envelope-fill"
                aria-hidden="true"
                >\\ </b-icon
              >Continue with Next Envelope
            </button>
          </li>
          <li
            class="mt-1"
            v-else-if="
              tag.includes('receipt') &&
              allReceiptsGenerated == $store.state.dataStore.requested_envelopes
            "
          >
            <button @click="startCycle()">
              <b-icon
                class="text-warning mr-3"
                icon="wallet-fill"
                aria-hidden="true"
              >
              </b-icon
              >Start with New Job
            </button>
          </li>
          <li class="quitBtn">
            <button @click="quitTheProcedure()">
              <b-icon
                class="text-danger mr-3"
                icon="x-circle-fill"
                aria-hidden="true"
              ></b-icon
              >Quit The Procedure
            </button>
          </li>
        </ul>
        <small> </small>
      </div>

      <div class="myModel">
        <div>
          <b-modal
            id="warn-about-receipt-generation"
            header-border-variant="primary"
            footer-border-variant="primary"
            body-bg-variant="primary"
            header-bg-variant="primary"
            footer-bg-variant="primary"
            :visible="warn_about_receipt_geration_first"
            centered
            title="Please Generate Receipt First"
          >
            <h6 class="text-warning">
              Generating Previous receipt is necessary before proceeding further
            </h6>
            <template #modal-footer>
              <!-- Emulate built in modal footer ok and cancel button actions -->
              <b-button
                class="btn round-border btn-success"
                size="sm"
                variant="success"
                @click="hidePopup()"
              >
                OK
              </b-button>
            </template>
          </b-modal>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Button from "../components/Global/Button.vue";
import { mapGetters, mapActions } from "vuex";

export default {
  components: { Button },

  data() {
    return {
      tag: "",
      options: {
        text: {
          color: "#FFFFFF",
          shadowEnable: true,
          shadowColor: "#000000",
          fontSize: 14,
          dynamicPosition: false,
          hideText: false,
        },
        progress: {
          color: "#36a142",
          backgroundColor: "#202962",
          inverted: false,
        },
        layout: {
          height: 120,
          width: 120,
          verticalTextAlign: 61,
          horizontalTextAlign: 43,
          zeroOffset: 0,
          strokeWidth: 10,
          progressPadding: 0,
          type: "circle",
        },
      },
      warn_about_receipt_geration_first: false,
    };
  },
  computed: {
    ...mapGetters("dataStore", ["allReceiptsGenerated",'getPercentage']),
  },
  mounted() {
    this.$forceUpdate();
    this.addTittle();
  },
  watch: {
    $route: {
      handler: function (newVal) {
        console.log("new value in route", newVal);
        var title = this.$route.fullPath;
        var res = title.split("/");
        var path = res[1];
        this.tag = path.replace(/-/g, " ");
        if (this.tag.includes("?")) {
          let tag_to_be_split = this.tag.split("?");
          this.tag = tag_to_be_split[0];
        }
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions("dataStore", [
      "resetState",
      "setPreviousPageOnCustomerChange",
      "resetCycle",
      "setCycle",
      "resetCycleForNewEnvelope",
    ]),

    startCycle() {
      sessionStorage.clear();
      this.resetState();
      this.$router.push("/").catch();
    },
    quitTheProcedure() {
      this.resetState();
      this.$router.push("/").catch({});
    },
    changeCustomer() {
      console.log(this.$route.fullPath);
      this.setPreviousPageOnCustomerChange(this.$route.fullPath);
      this.$router.push("/").catch();
    },
    addTittle() {
      var title = this.$route.fullPath;
      var res = title.split("/");
      var path = res[1];
      this.tag = path.replace(/-/g, " ");
      if (this.tag.includes("?")) {
        let tag_to_be_split = this.tag.split("?");
        this.tag = tag_to_be_split[0];
      }
    },
    moveToNextEnvelope() {
      var state = this.$store.state.dataStore;
      var no_of_generated_envelopes = state.no_of_generated_envelopes;
      // as we are checking previous data thats why -1 is used and envelope
      var is_receipt_generated =
        state.items_price_detail[state.no_of_generated_envelopes][
          state.envelope_numbers[state.selected_envelope_number]
        ]["receipt_generated"];
      if (is_receipt_generated) {
        var context = this;
        // new Promise(function(resolve, reject) {
        context.$store.commit("dataStore/setSelectedEnvelopeNumber");
        context.$store.commit("dataStore/setNoOfGeneratedEnvelopes");
        context.setCycle(context.$store.state.dataStore.current_cycle + 1);
        context.resetCycle(true);
        // });
      } else {
        this.$bvModal.show("warn-about-receipt-generation");
      }
    },
    hidePopup() {
      this.$bvModal.hide("warn-about-receipt-generation");
    },
    deleteCustomer(email) {
      this.isLoading = true;

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
          this.isLoading = false;
          this.$emit("showAlert", [
            "Customer deleted successfully.",
            "success",
          ]);
          if (this.$store.state.dataStore.customer_details["email"] == email) {
            this.removeCustomer();
          }
        })
        .catch((error) => {
          this.isLoading = false;
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
  },
};
</script>

<style scoped>
</style>