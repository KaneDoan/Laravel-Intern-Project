<template>
  <div class="mk-gymform row">

    <div class="pl-0 col-12">
      <div class="col-12 hf-base-card hf-service-card-padding admin-input-wrap">
        <v-row>
          <v-col cols="12">
            <h2 v-if="routine.id" class="mb-4 color-primary">{{ routine.name }}</h2>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Name</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="routine.name"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Slug</label>
          </v-col>
          <v-col cols="12" md="6">
            <p>
              {{routine.slug}}
            </p>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Code</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="routine.code"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Default Set</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="routine.default_set"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Work Timer</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="routine.timer"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Rest Timer</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="routine.rest_timer"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Description</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-textarea
              outlined
              v-model="routine.description"
              placeholder=""
              class="text-field"
            ></v-textarea>
          </v-col>
        </v-row>

        <div class="col-12 mb-4">
            <button
                v-if="routine.id"
                @click="handleSubmit()"
                class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
            >
                <strong>Update Routine</strong>
            </button>

            <button
                v-else
                @click="handleSubmit()"
                class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
            >
                <strong>Create Routine</strong>
            </button>

            <button
                v-if="routine.id"
                @click="handleDelete()"
                class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-danger"
            >
                <strong>Delete Routine</strong>
            </button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import Routine from "../../models/Routine";

export default {
  props: {
    initial_routine: {
      type: Object,
    },
  },
  async mounted() {
    this.getRoutine();
    console.log(this.initial_routine);
  },
  data() {
    return {
      routine: new Routine(this.initial_routine),
    };
  },
  computed: {
    postUrl: function () {
    if (this.routine.id) {
      return `/api/routines/${this.routine.id}`;
        }
      return `/api/routines`;
    },
  },
  methods: {

    async getRoutine() {
      if (this.initial_routine) {
        this.routine = await Routine
        .append([
          "thumbnail_path_url",
          "video_path_url"
        ])
        .find(this.initial_routine.id);
      }
    },

    async handleSubmit() {
      this.routine.save().then((response) => {
        if (response.id) {
          if (!this.initial_routine) {
            window.location.href = "/routines/" + response.id;
          }
        }
      });
    },

    async handleDelete() {
      this.$swal({
        title: "Are you sure you want to delete this?",
        customClass: {
          confirmButton: "order-2 btn btn-danger ml-1",
          cancelButton: "order-1 btn hf-btn-secondary mr-1",
        },
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Confirm",
        iconHtml: "",
      }).then(async (result) => {
        if (result.isConfirmed) {
          let routine = new Routine(this.initial_routine);
          routine.delete().then((response) => {
            window.location.href = "/routines/";
          });
        }
      });
    },

  },
};
</script>
