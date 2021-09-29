<template>
  <div class="mk-gym-form row">
    <div class="px-0 mb-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start">
      <h1 class="ml-0 mb-0">Gym Information</h1>
      <div class="d-flex flex-column flex-sm-row">
      </div>
    </div>

    <div class="col-12 px-0">
      <!-- Edit gym -->
      <div v-if="gymId">
        <div class="col-sm-12 col">
            <gym-form
            :initial_gym="gym"
            ref="gymFormRef"
            ></gym-form>
        </div>
      </div>

      <!-- Create gym -->
      <div v-else class="container-fluid">
        <gym-form :init_gym="gym" ref="gymFormRef"></gym-form>
      </div>
    </div>

    <div class="col-12 mb-4">
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
</template>

<script>
import Gym from "../../models/Gym";
export default {
  props: {
    initial_gym: {
      type: Object,
    },
  },
  async mounted() {
    if(this.initial_gym){
      console.log("mounted");
    }
    else{
      console.log("not mounted");
    }
  },
  data() {
    return {
      gym: new Gym(this.initial_gym),
      gymId: this.initial_gym ? this.initial_gym.id : null,
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
          let gym = new Gym(this.initial_gym);
          gym.delete().then((response) => {
            window.location.href = "/gyms/";
          });
        }
      });
    },

    handleSubmit() {
      this.$refs.gymFormRef.handleSubmit();
    },
  },
};
</script>
