<template>
  <div class="mk-exercise-link-routine-table row">
    <div class="pl-0 col-12">
      <div class="col-12 hf-base-card hf-service-card-padding">

        <v-row>
          <v-col cols="12" class="pt-0">
            <h2 class="mb-0">Exercise Details</h2>
          </v-col>
        </v-row>




        <v-row>
          <v-col cols="12">
            <paginated-table
              v-if="exercise_routines.data"
              :tableData="tableData"
              :paginatedData="exercise_routines"
              @pagination-change-page="getExerciseRoutines"
            ></paginated-table>
          </v-col>
        </v-row>

        <!-- /Add Exercise Modal -->
        <div class="d-flex flex-column flex-md-row">
            <v-dialog v-model="dialog" max-width="600px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                    class="btn-primary"
                  >
                    Add Exercise
                  </v-btn>
                </template>

                <v-card>
                  <v-card-title>
                    <div
                      class="
                        w-100
                        d-flex
                        justify-content-between
                        align-items-center
                      "
                    >
                      <div>
                        <h2 class="mb-0">Add Exercise</h2>
                      </div>

                      <button
                        class="btn-text px-2 py-1"
                        @click="dialog = false"
                      >
                        <i class="fal fa-times text-black"></i>
                      </button>
                    </div>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="12">
                          <label>Exercise</label>
                          <v-select
                            outlined
                            v-model="exercise_routine.exercise_id"
                            :items="exercisesData"
                            item-value="id"
                            item-text="name"
                          >
                          </v-select>
                        </v-col>
                      </v-row>

                      <v-row>
                        <v-col cols="12" sm="12">
                          <label>Sort Id</label>
                            <v-text-field
                                :value="range[0]"
                                class="mt-0 pt-0"
                                hide-details
                                v-model="exercise_routine.sort_id"
                                single-line
                                type="number"
                                style="width: 200px"
                                @change="$set(range, 0, $event)"
                            >
                            </v-text-field>
                        </v-col>
                      </v-row>

                      <v-row>
                        <v-col cols="12" sm="12">
                          <label>Reps</label>
                            <v-text-field
                                :value="range[0]"
                                class="mt-0 pt-0"
                                hide-details
                                v-model="exercise_routine.default_reps"
                                single-line
                                type="number"
                                style="width: 200px"
                                @change="$set(range, 0, $event)"
                            >
                            </v-text-field>
                        </v-col>
                      </v-row>

                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-container>
                      <v-row>
                        <v-col cols="12">
                          <div
                            class="
                              d-flex
                              justify-content-between
                              align-items-center
                            "
                          >
                            <button
                              @click="dialog = false"
                              class="hf-btn-secondary"
                              text
                            >
                              Cancel
                            </button>
                            <button
                              class="btn-primary"
                              @click="addExercise"
                              text
                            >
                              Add
                            </button>
                          </div>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-actions>
                </v-card>
              </v-dialog>
        </div>

      </div>
    </div>
  </div>
</template>

<script>

import ExerciseRoutine from "../../models/ExerciseRoutine";
import Exercise from '../../models/Exercise'

export default {
  props: {
    initial_routine: {
      type: Object,
      default: null,
    },

    init_exercise_routines: {
      type: Object,
      default: null,
    },
  },

  mounted() {
    this.getExerciseRoutines();
    this.getExercises();
  },

  data() {
    return {
      search: null,
      dialog: false,
      min: -50,
      max: 90,
      range: [0, 90],
      exercise_routines: {},
      exercise_routine: new ExerciseRoutine({}),
      exercises: {},
      exercisesData:[],
      tableData: {
        columns: [
          {
            label: "ID",
            name: "id",
            sortable: true
          },
          {
            label: "Sort ID",
            name: "sort_id",
            sortable: true,
          },
          {
            label: "Name",
            name: "exercise.name",
            sortable: false
          },
          {
            label: "Description",
            name: "exercise.description",
            sortable: false
          },
          {
            label: "Display",
            name: "display_id",
            sortable: false
          },
          {
            label: "Cover Image",
            name: "exercise.thumbnail_path_url",
            sortable: false
          },
          {
            label: "Video",
            name: "exercise.video_path_url",
            sortable: false
          },

        ],
        edit: false,
        showSearch: false,
        showPerPage: false,
      }
    };
  },

  methods: {

    async getExerciseRoutines(page = 1, sortColumn = null, query = null, per_page = 15, desc = false) {
      let exercise_routines = ExerciseRoutine.page(page).include('routine', 'exercise').limit(per_page);

      if (sortColumn) {
        exercise_routines.orderBy(
          (desc ? "-" : "") + (sortColumn.sort_name || sortColumn.name)
        );
      } else {
        exercise_routines.orderBy("-created_at");
      }

      if (query) {
        exercise_routines.where("search", query);
      }

      exercise_routines
        // .limit(limit)
        .where("routine_id", this.initial_routine.id)
        .include(
          "routine",
          "exercise"
        );

      this.exercise_routines = await exercise_routines.get();
      console.log(this.exercise_routines);
    },

    async getExercises(
        sortColumn = null,
        query = null,
        per_page = 100,
    ) {
        console.log('getExercises')
      let exercises = Exercise.include('routines').limit(per_page);

      if (sortColumn) {
        exercises.orderBy(
          (desc ? "-" : "") + (sortColumn.sort_name || sortColumn.name)
        );
      } else {
        exercises.orderBy("-created_at");
      }
      if (query) {
        exercises.where("search", query);
      }
      this.exercises = await exercises.get();
      this.exercisesData = this.exercises.data;
      console.log(this.exercisesData);
    },

    async addExercise() {

    //   const exercise_routines = new ExerciseRoutine();

      this.exercise_routine.routine_id = this.initial_routine.id;
    //   this.exercise_routine.exercise_id = this.initial_routine.id;

      await this.exercise_routine.save().then((response) => {
        this.dialog = false;
        this.getExerciseRoutines();
      });
    },

  }
};
</script>
