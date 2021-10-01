<template>
  <div class="mk-user-form row">
    <div class="px-0 mb-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start">
      <h1 class="ml-0 mb-0">User Details</h1>
    </div>

    <div class="col-12 px-0">
      <!-- Edit user -->
      <div v-if="userId">
        <div class="col-sm-12 col">
            <user-form
            :initial_user="user"
            ref="userFormRef"
            ></user-form>
        </div>
      </div>

      <!-- Create user -->
      <div v-else class="container-fluid">
        <user-form :init_user="user" ref="userFormRef"></user-form>
      </div>
    </div>

    <div class="px-0 mb-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start">
      <h1 class="ml-0 mb-0">Assigned Gym</h1>
    </div>

    <div class="col-12 mb-4">
    <button
        v-if="user.id"
        @click="handleSubmit()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
    >
        <strong>Update User</strong>
    </button>

    <button
        v-else
        @click="handleSubmit()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
    >
        <strong>Create User</strong>
    </button>

    <button
        v-if="user.id"
        @click="handleDelete()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-danger"
      >
        <strong>Delete User</strong>
    </button>
    </div>

  </div>
</template>

<script>
import User from "../../models/User";
export default {
  props: {
    initial_user: {
      type: Object,
    },
  },
  async mounted() {
    if(this.initial_user){
      console.log("mounted");
    }
    else{
      console.log("not mounted");
    }
  },
  data() {
    return {
      user: new User(this.initial_user),
      userId: this.initial_user ? this.initial_user.id : null,
    };
  },
  computed: {},

  methods: {
    handleDelete() {
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
          let user = new User(this.initial_user);
          user.delete().then((response) => {
            window.location.href = "/users/";
          });
        }
      });
    },

    handleSubmit() {
      this.$refs.userFormRef.handleSubmit();
    },
  },
};
</script>
