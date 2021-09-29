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
            <label>Image Path</label>
          </v-col>
          <v-col cols="11" sm="6">
            <v-file-input
              outlined
              @change="selectFile"
              accept="image/png, image/jpeg, image/bmp, image/jpg"
              placeholder="Pick an image"
              append-icon="fas fa-camera"
            ></v-file-input>
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
      </div>
    </div>
  </div>
</template>

<script>
import Gym from "../../models/Gym";
import axios from "axios";

export default {
  props: {
    initial_gym: {
      type: Object,
      default: null,
    },
  },
  async mounted() {
    this.getGym();
  },
  data() {
    return {
      gym: new Gym(this.initial_gym),

    };
  },
  computed: {},
  methods: {
    selectFile(file) {
      console.log(file);
      if (this.gym.id) {
        this.gym.file_name = file.name;
      }
    },

    showDetail(data) {
      if (data.thumbnail_path_url) {
        window.open(data.thumbnail_path_url, "_blank");
      } else {
        console.log("does not exist");
      }
    },

    async getGym() {
      if (this.initial_gym) {
        this.gym = await Gym.include(["users"])
        .append([
          "thumbnail_path_url",
        ])
        .find(this.initial_gym.id);
      }
    },
    async handleSubmit() {

      this.gym.save().then((response) => {
        if (response.id) {
          if (!this.initial_gym) {
            window.location.href = "/gyms/" + response.id + "/edit";
          }
        }
      });
    },
  },
};
</script>
