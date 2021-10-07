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

        <!-- tab navs -->
        <v-tabs v-model="currentTab" height="60" show-arrows fixed-tabs>
          <v-tab
            v-for="(item, index) in items"
            :class="{ active: currentTab === index }"
            @click="getCurrentTab(index)"
            :key="item"
            :tabindex="index"
          >
            {{ item }}
          </v-tab>
        </v-tabs>

        <v-tabs-items v-model="currentTab">
          <v-card flat>
            <div v-show="currentTab === 0" class="col-sm-12 col">
              <routine-form
                :initial_routine="routine"
                ref="routineFormRef"
              ></routine-form>
            </div>

            <div v-show="routineId && currentTab === 1" class="col-sm-12 col">
              <exercise-routine-detail
                :initial_routine="routine"
              ></exercise-routine-detail>
            </div>

          </v-card>
        </v-tabs-items>
      </div>

      <!-- Create routine -->
      <div v-else class="container-fluid">
        <routine-form :init_routine="routine" ref="routineFormRef"></routine-form>
      </div>
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
      currentTab: 0,
      items: [
        "Routine Details",
        "Exercise Details",
      ],
    };
  },
  computed: {},

  methods: {

    getCurrentTab(index) {
      this.currentTab = index;
    },
  },
};
</script>
