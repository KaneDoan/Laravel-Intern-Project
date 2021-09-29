<template>
  <div class="mk-be-gym-index row">
    <div
      class="px-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start"
      style="margin-bottom: 14px;"
    >
      <h1 class>Gym Manager</h1>

      <div class="d-flex flex-column flex-md-row">
        <a
          :href="`/gyms/create`"
          class="btn btn-success mb-3 mb-md-0 ml-md-3"
        >Add</a>
      </div>
    </div>

    <div class="container-fluid mb-4 px-0">
      <div class="row mx-0">
        <div class="col-12 px-0">
          <div class="gym-card hf-base-card bg-white ">
            <paginated-table
              v-if="gyms.data"
              :tableData="tableData"
              :paginatedData="gyms"
              @pagination-change-page="getGyms"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import Gym from '../../models/Gym'

export default {

    mounted() {
        console.log('mounted');
        this.getGyms();
        console.log('done');
    },
    data(){
        return {
            export: false,
            gyms: {},
            tableData: {
                columns: [
                    {
                        label: "ID",
                        name: "id",
                        sortable: true
                    },
                    {
                        label: "Title",
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
                viewUrl: "/gyms",
            }
        };
    },
    methods: {

    async getGyms(
      page = 1,
      sortColumn = null,
      query = null,
      per_page = 15,
      desc = false
    ) {
        console.log('getGyms')
      let gyms = Gym.page(page).include('users', 'usersCount').limit(per_page);

      if (sortColumn) {
        gyms.orderBy(
          (desc ? "-" : "") + (sortColumn.sort_name || sortColumn.name)
        );
      } else {
        gyms.orderBy("-created_at");
      }

      if (query) {
        gyms.where("search", query);
      }

      if (this.export) {
        gyms.params({
          export: true,
        });
        this.export = false;
        window.open(
          "/gyms" + gyms._builder.query(),
        //   "_blank"
        );
      }

      this.gyms = await gyms.get();
    console.log(gyms.data);
    console.log("test");
    }
  }
};
 </script>
