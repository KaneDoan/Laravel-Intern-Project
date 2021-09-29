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
              v-model="image"
              type="file" class="input"
              outlined
              @change="selectFile"
              accept="image/png, image/jpeg, image/bmp, image/jpg"
              placeholder="Pick an image"
              append-icon="fas fa-camera"
            ></v-file-input>
          </v-col>

          <v-col>
          <h4>Preview</h4>
          <v-img :src="imageUrl" style="border: 1px dashed #ccc; max-height: 250px" />
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
    },
  },
  async mounted() {
    this.getGym();
    console.log(this.initial_gym);
  },
  data() {
    return {
      gym: new Gym(this.initial_gym),
      image: undefined,
      imageUrl: ''
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
  methods: {
    createImage(file) {
    const reader = new FileReader();

    reader.onload = e => {
      this.imageUrl = e.target.result;
    };
    reader.readAsDataURL(file);
    },

    selectFile(file) {
      console.log(file);
      if (this.gym.id) {
        this.gym.file_name = file.name;
        console.log(file.name);
      }
      if (!file) {
        return;
    }
        this.createImage(file);
    },

    checkValidation() {
      if (this.file == null) {
        if (!this.gym.id) {
          Vue.swal("", "Please add a file", "error");
          return;
        }
      }

      if (this.gym.file_name && this.gym.file_name.length) {
      } else {
        Vue.swal("", "Please add a file name", "error");
        return;
      }
      this.handleSubmit();
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
        this.gym = await Gym
        .append([
          "thumbnail_path_url",
        ])
        .find(this.initial_gym.id);
      }
    },
    async handleSubmit() {

    var formData = new FormData();

    Object.entries(this.gym).forEach(([key, value]) => {
        if (!(key == "file")) {
          formData.append(key, value);
        }
      });

        if (this.gym.id) {
        var method = "put";
      } else {
        var method = "post";
      }

      if (this.gym.id) {
        formData.append("_method", "put");
      }

      if (this.file) {
        formData.append("file", this.file, this.file.name);
      }

      //formData.append("client_id", this.init_client.id);
    await axios
        .post(this.postUrl, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          Vue.swal({
            title: " ",
            text: "Updated",
            icon: "success",
            toast: true,
            position: "top-end",
            timer: 2000,
          });

          this.getGym();
        })
        .catch(function (err) {
          if (err.response.status == 422) {
            var errorText = "";
            Object.entries(err.response.data.errors).forEach(([key, value]) => {
              value.forEach((errorMessage) => {
                errorText += "" + errorMessage + " <br>";
              });
            });
            Vue.swal("", errorText, "error");
            return err.response;
          } else {
            Vue.swal("", "Server error", "error");
          }
        });

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
