<template>
  <div class="mk-be-routine-index row">
    <div
      class="px-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start"
      style="margin-bottom: 14px;"
    >
      <h1 class>Routine Manager</h1>

      <div class="d-flex flex-column flex-md-row">
        <a
          :href="`/routines/create`"
          class="btn btn-success mb-3 mb-md-0 ml-md-3"
        >Add</a>
      </div>
    </div>

    <div class="container-fluid mb-4 px-0">
      <div class="row mx-0">
        <div class="col-12 px-0">
          <div class="routine-card hf-base-card bg-white ">
            <paginated-table
              v-if="routines.data"
              :tableData="tableData"
              :paginatedData="routines"
              @pagination-change-page="getRoutines"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import Routine from '../../models/Routine'

export default {

    mounted() {
        console.log('mounted');
        this.getRoutines();
        console.log('done');
    },
    data(){
        return {
            export: false,
            routines: {},
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
                        label: "Code",
                        name: "code",
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
                viewUrl: "/routines",
            }
        };
    },
    methods: {

    async getRoutines(
      page = 1,
      sortColumn = null,
      query = null,
      per_page = 15,
      desc = false
    ) {
        console.log('getRoutines')
      let routines = Routine.page(page).include('exercises').limit(per_page);

      if (sortColumn) {
        routines.orderBy(
          (desc ? "-" : "") + (sortColumn.sort_name || sortColumn.name)
        );
      } else {
        routines.orderBy("-created_at");
      }

      if (query) {
        routines.where("search", query);
      }

      if (this.export) {
        routines.params({
          export: true,
        });
        this.export = false;
        window.open(
          "/routines" + routines._builder.query(),
        //   "_blank"
        );
      }
      this.routines = await routines.get();
    }
  }
};
 </script>
