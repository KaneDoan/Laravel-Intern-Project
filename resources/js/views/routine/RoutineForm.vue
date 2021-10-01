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
              {{exercise.slug}}
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
  },
};
</script>
