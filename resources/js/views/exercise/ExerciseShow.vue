<template>
  <div class="mk-exercise-form row">
    <div class="px-0 mb-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start">
      <h1 class="ml-0 mb-0">Exercise Information</h1>
      <div class="d-flex flex-column flex-sm-row">
      </div>
    </div>

    <div class="col-12 px-0">
      <!-- Edit exercise -->
      <div v-if="exerciseId">
        <div class="col-sm-12 col">
            <exercise-form
            :initial_exercise="exercise"
            ref="exerciseFormRef"
            ></exercise-form>
        </div>
      </div>

      <!-- Create exercise -->
      <div v-else class="container-fluid">
        <exercise-form :init_exercise="exercise" ref="exerciseFormRef"></exercise-form>
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
    },
  },
  async mounted() {
    if(this.initial_exercise){
      console.log("mounted");
    }
    else{
      console.log("not mounted");
    }
  },
  data() {
    return {
      exercise: new Exercise(this.initial_exercise),
      exerciseId: this.initial_exercise ? this.initial_exercise.id : null,
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
