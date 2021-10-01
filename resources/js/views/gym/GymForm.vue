<template>
  <div class="mk-gymform row">

    <div class="pl-0 col-12">
      <div class="col-12 hf-base-card hf-service-card-padding admin-input-wrap">
        <v-row>
          <v-col cols="12">
            <h2 v-if="gym.id" class="mb-4 color-primary">{{ gym.name }}</h2>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Name</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="gym.name"
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
            <v-text-field
              outlined
              v-model="gym.slug"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" sm="3">
            <label>Add Image</label>
          </v-col>

          <v-col cols="11" sm="6">
            <div
                v-cloak
                style="height: 300px"
                class="text-center bg-light"
            >
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
          <v-col cols="12" md="3">
            <label>Pin</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="gym.pin"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>No. of Displays</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="gym.no_of_displays"
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
              v-model="gym.description"
              placeholder=""
              class="text-field"
            ></v-textarea>
          </v-col>
        </v-row>

        <!-- <v-row>
          <v-col cols="12" md="4">
            <label>Xero contact id</label>
            <v-text-field outlined v-model="client.xero_contact_id" placeholder="" class="text-field"></v-text-field>
          </v-col>
        </v-row> -->

    <button
        v-if="gym.id"
        @click="handleSubmit()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
    >
        <strong>Update Gym</strong>
    </button>


      </div>
    </div>
  </div>
</template>

<script>
import Gym from "../../models/Gym";
import Media from "../../models/Media";
import axios from "axios";

export default {
  props: {
    initial_gym: {
      type: Object,
      default: null,
    },
  },

  data() {
    return {
      gym: new Gym(this.initial_gym),
      media: null,
      selectedImage: null,
      medias: {},
    };
  },
  computed: {
    postUrl: function () {
    if (this.gym.id) {
      return `/api/gyms/${this.gym.id}`;
        }
      return `/api/gyms`;
    },
  },
  async mounted() {
    this.getGym();
    // this.getMedias();
    console.log(this.media);
  },

  methods: {


    selectImage(e) { this.selectedImage = e;
        console.log( this.selectedImage);
    },

    async getGym() {
      if (this.initial_gym) {
        this.gym = await Gym
        .append([
         "thumbnail_path_url",
        ])
        .find(this.initial_gym.id);
      }
    },

    async handleSubmit() {

// const model = await Gym.find(this.initial_gym.id)

// model.thumbnail = this.media

// model.patch()

        if(this.initial_gym){
            if (this.media){
            this.gym.thumbnail = this.selectedImage;
            this.gym._method = 'patch';
            }
        }


      this.gym.save().then((response) => {
        if (response.id) {
          if (!this.initial_gym) {
            window.location.href = "/gyms/" + response.id;
          }
        }
      });
    },
  },
};
</script>
