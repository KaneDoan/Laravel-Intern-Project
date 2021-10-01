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
          <v-col cols="12" sm="3">
            <label>Add Image</label>
          </v-col>

          <v-col cols="11" sm="6">
            <div
                v-cloak
                style="height: 500px"
                class="text-center bg-light"
            >
                <img v-if="imageUrl" :src="imageUrl" style="max-width: 100%; max-height: 400px" />

                <v-file-input
                    v-model="media"
                    type="file"
                    label="Attachments"
                    dence
                    @change="selectImage"
                    accept="image/png, image/jpeg, image/bmp, image/jpg"
                    placeholder="Pick an image"
                    append-icon="fas fa-camera"
                ></v-file-input>

            </div>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" sm="3">
            <label>Add Video</label>
          </v-col>

          <v-col cols="11" sm="6">
            <div
                v-cloak
                style="height: 500px"
                class="text-center bg-light"
            >
                <img v-if="videoUrl" :src="videoUrl" style="max-width: 100%; max-height: 400px" />

                <v-file-input
                    v-model="media"
                    type="file"
                    label="Attachments"
                    dence
                    @change="selectVideo"
                    accept="video/mp4, video/mov, video/fly, video/ogg"
                    placeholder="Pick a video"
                    append-icon="fas fa-video"
                ></v-file-input>

            </div>
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
      default: null,
      media: null,
      imageUrl: null,
      videoUrl:null,
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
