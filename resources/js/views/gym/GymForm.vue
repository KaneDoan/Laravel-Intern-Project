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
                style="height: 500px; display: flex;"
                class="text-center bg-light"
            >
                <img v-if="gym.thumbnail_path_url" :src="gym.thumbnail_path_url" style="max-width: 100%; max-height: 400px" />

                <v-file-input
                    v-model="media"
                    type="file"
                    label="Attachments"
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

    <button
        v-else
        @click="handleSubmit()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
    >
        <strong>Create Gym</strong>
    </button>

    <button
        v-if="gym.id"
        @click="handleDelete()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-danger"
      >
        <strong>Delete Gym</strong>
    </button>

      </div>
    </div>
  </div>
</template>

<script>
import Gym from "../../models/Gym";
import Media from "../../models/Media";

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
  },

  methods: {

    selectedImage(e) {
      const file = e;
      this.gym.thumbnail_path_url = URL.createObjectURL(file);
    },

    getThumbNail(){
        return this.gym.thumbnail_path_url;
    },

    async getGym() {
      if (this.initial_gym) {
        this.gym = await Gym
        .append([
         "thumbnail_path_url",
        ])
        .find(this.initial_gym.id);
        console.log(this.gym);
      }
    },

    async handleSubmit() {

        if(this.initial_gym){
            if (this.media){
            this.gym.thumbnail = this.media;
            this.gym._method = 'put';
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
          let gym = new Gym(this.initial_gym);
          gym.delete().then((response) => {
            window.location.href = "/gyms/";
          });
        }
      });
    },
  },
};
</script>
