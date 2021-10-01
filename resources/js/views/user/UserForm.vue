<template>
  <div class="mk-userform row">

    <div class="pl-0 col-12">
      <div class="col-12 hf-base-card hf-service-card-padding admin-input-wrap">
        <v-row>
          <v-col cols="12">
            <h2 v-if="user.id" class="mb-4 color-primary">{{ user.name }}</h2>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Name</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="user.name"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Email</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="user.email"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Password</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              v-model="user.password"
              placeholder=""
              class="text-field"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3">
            <label>Role</label>
          </v-col>
          <v-col cols="12" md="6">
            <v-radio-group
              outlined
              v-model="user.is_admin"
            >
                <v-radio
                    label="Admin"
                    :value="true"
                />

                <v-radio
                    label="company"
                    :value="false"
                />

            </v-radio-group>
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
    initial_user: {
      type: Object,
    },
  },
  async mounted() {
    this.getRoutine();
    console.log(this.initial_user);
  },
  data() {
    return {
      user: new Routine(this.initial_user),
    };
  },
  computed: {
    postUrl: function () {
    if (this.user.id) {
      return `/api/users/${this.user.id}`;
        }
      return `/api/users`;
    },
  },
  methods: {
    async getRoutine() {
      if (this.initial_user) {
        this.user = await Routine
        .append([
          "thumbnail_path_url",
          "video_path_url"
        ])
        .find(this.initial_user.id);
      }
    },
    async handleSubmit() {
      this.user.save().then((response) => {
        if (response.id) {
          if (!this.initial_user) {
            window.location.href = "/users/" + response.id;
          }
        }
      });
    },
  },
};
</script>
