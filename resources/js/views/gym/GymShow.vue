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

    handleSubmit() {
      this.$refs.gymFormRef.handleSubmit();
    },
  },
};
</script>
