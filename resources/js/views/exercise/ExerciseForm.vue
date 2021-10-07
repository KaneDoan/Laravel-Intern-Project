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
                <img v-if="exercise.thumbnail_path_url" :src="exercise.thumbnail_path_url" style="max-width: 100%; max-height: 400px" />

                <v-file-input
                    v-model="media.photo"
                    type="file"
                    name = "thumbnail"
                    dence
                    @change="selectedImage"
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
                style="height: 500px"
                class="text-center bg-light"
            >

            <!-- <div class="video-player">
                <video class="video" ref="video" v-if="exercise.video_path_url" :src="exercise.video_path_url" width="400" height="400" type="video/mp4">
                    <source v-if="exercise.video_path_url" :src="exercise.video_path_url" type="video/mp4">
                </video>
            </div> -->

                <video ref="videoRef" v-if="exercise.video_path_url" :src="exercise.video_path_url" width="400" height="400" type="video/*" autoplay>
                </video>

                <v-file-input
                    v-model="media.video"
                    type="file"
                    name = "video"
                    dence
                    @change="selectedVideo"
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

        <button
            v-if="exercise.id"
            @click="handleSubmit()"
            class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
        >
            <strong>Update Exercise</strong>
        </button>

        <button
            v-else
            @click="handleSubmit()"
            class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
        >
            <strong>Create Exercise</strong>
        </button>

        <button
            v-if="exercise.id"
            @click="handleDelete()"
            class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-danger"
        >
            <strong>Delete Exercise</strong>
        </button>

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
    },
  },

  data() {
    return {
      exercise: new Exercise(this.initial_exercise),
      media: {
        thumbnail:null,
        video:null
      },
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

  async mounted() {
    this.getExercise();
  },

  methods: {

    selectedImage(image) {
      this.exercise.thumbnail_path_url = URL.createObjectURL(image);
      console.log(this.exercise.thumbnail_path_url);
    },

    selectedVideo(video) {
      this.exercise.video_path_url = URL.createObjectURL(video);
      console.log(this.exercise.video_path_url);
    },

    async getExercise() {
      if (this.initial_exercise) {
        this.exercise = await Exercise
        .append([
          "thumbnail_path_url",
          "video_path_url"
        ])
        .find(this.initial_exercise.id);
        console.log(this.exercise);
      }
    },

    async handleSubmit() {

      if(this.initial_exercise){
            if (this.media){
            this.exercise.thumbnail = this.media.thumbnail;
            this.exercise.video     = this.media.video;
            this.exercise._method = 'put';
            }
        }

      this.exercise.save().then((response) => {
        if (response.id) {
          if (!this.initial_exercise) {
            window.location.href = "/exercises/" + response.id;
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
          let exercise = new Exercise(this.initial_exercise);
          exercise.delete().then((response) => {
            window.location.href = "/exercises/";
          });
        }
      });
    },

  },
};
</script>
