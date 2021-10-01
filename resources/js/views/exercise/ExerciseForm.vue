<template>
  <div class="mk-exerciseform row">

    <div class="pl-0 col-12">
      <div class="col-12 hf-base-card hf-service-card-padding admin-input-wrap">
        <v-row>
          <v-col cols="12">
            <h2 v-if="exercise.id" class="mb-4 color-primary">{{ exercise.name }}</h2>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Name</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="exercise.name"
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
            <label>Image</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="exercise.code"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Video</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="exercise.default_set"
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
              v-model="exercise.description"
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
import Exercise from "../../models/Exercise";

export default {
  props: {
    initial_exercise: {
      type: Object,
    },
  },
  async mounted() {
    this.getExercise();
    console.log(this.initial_exercise);
  },
  data() {
    return {
      exercise: new Exercise(this.initial_exercise),
    };
  },
  computed: {
    postUrl: function () {
    if (this.exercise.id) {
      return `/api/exercises/${this.exercise.id}`;
        }
      return `/api/exercises`;
    },
  },
  methods: {
    async getExercise() {
      if (this.initial_exercise) {
        this.exercise = await exercise
        .append([
          "thumbnail_path_url",
          "video_path_url"
        ])
        .find(this.initial_exercise.id);
      }
    },
    async handleSubmit() {
      this.exercise.save().then((response) => {
        if (response.id) {
          if (!this.initial_exercise) {
            window.location.href = "/exercises/" + response.id;
          }
        }
      });
    },
  },
};
</script>
