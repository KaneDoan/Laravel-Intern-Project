<template>
  <div class="mk-be-exercise-index row">
    <div
      class="px-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start"
      style="margin-bottom: 14px;"
    >
      <h1 class>Exercise Manager</h1>

      <div class="d-flex flex-column flex-md-row">
        <a
          :href="`/exercises/create`"
          class="btn btn-success mb-3 mb-md-0 ml-md-3"
        >Add</a>
      </div>
    </div>

    <div class="container-fluid mb-4 px-0">
      <div class="row mx-0">
        <div class="col-12 px-0">
          <div class="exercise-card hf-base-card bg-white ">
            <paginated-table
              v-if="exercises.data"
              :tableData="tableData"
              :paginatedData="exercises"
              @pagination-change-page="getExercises"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import Exercise from '../../models/Exercise'

export default {

    mounted() {
        console.log('mounted');
        this.getExercises();
        console.log('done');
    },
    data(){
        return {
            export: false,
            exercises: {},
            tableData: {
                columns: [
                    {
                        label: "ID",
                        name: "id",
                        sortable: true
                    },
                    {
                        label: "Name",
                        name: "name",
                        sortable: true
                    },
                    {
                        label: "Description",
                        name: "description",
                        sortable: true
                    },
                    {
                        label: "Action",
                        name: "",
                        sortable: true
                    },
                ],

                edit: false,
                showSearch: true,
                showPerPage: true,
                viewUrl: "/exercises",
            }
        };
    },
    methods: {

    async getExercises(
      page = 1,
      sortColumn = null,
      query = null,
      per_page = 15,
      desc = false
    ) {
        console.log('getExercises')
      let exercises = Exercise.page(page).include('routines').limit(per_page);

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

      if (this.export) {
        exercises.params({
          export: true,
        });
        this.export = false;
        window.open(
          "/exercises" + exercises._builder.query(),
        //   "_blank"
        );
      }
      this.exercises = await exercises.get();
    }
  }
};
 </script>
