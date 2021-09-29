<template>
  <div class="mk-routine-form row">
    <div class="px-0 mb-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start">
      <h1 class="ml-0 mb-0">Routine Information</h1>
      <div class="d-flex flex-column flex-sm-row">
      </div>
    </div>

    <div class="col-12 px-0">
      <!-- Edit routine -->
      <div v-if="routineId">
        <div class="col-sm-12 col">
            <routine-form
            :initial_routine="routine"
            ref="routineFormRef"
            ></routine-form>
        </div>
      </div>

      <!-- Create routine -->
      <div v-else class="container-fluid">
        <routine-form :init_routine="routine" ref="routineFormRef"></routine-form>
      </div>
    </div>

    <div class="col-12 mb-4">
    <button
        v-if="routine.id"
        @click="handleSubmit()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
    >
        <strong>Update Routine</strong>
    </button>

    <button
        v-else
        @click="handleSubmit()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-success"
    >
        <strong>Create Routine</strong>
    </button>

    <button
        v-if="routine.id"
        @click="handleDelete()"
        class="mt-3 mt-sm-0 ml-0 ml-sm-2 btn-danger"
      >
        <strong>Delete Routine</strong>
    </button>
    </div>

  </div>
</template>

<script>
import Routine from "../../models/Routine";
export default {
  props: {
    initial_routine: {
      type: Object,
    },
  },
  async mounted() {
    if(this.initial_routine){
      console.log("mounted");
    }
    else{
      console.log("not mounted");
    }
  },
  data() {
    return {
      routine: new Routine(this.initial_routine),
      routineId: this.initial_routine ? this.initial_routine.id : null,
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
          let routine = new Routine(this.initial_routine);
          routine.delete().then((response) => {
            window.location.href = "/routines/";
          });
        }
      });
    },

    handleSubmit() {
      this.$refs.routineFormRef.handleSubmit();
    },
  },
};
</script>
