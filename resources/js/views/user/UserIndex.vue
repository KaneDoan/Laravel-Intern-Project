<template>
  <div class="mk-be-user-index row">
    <div
      class="px-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start"
      style="margin-bottom: 14px;"
    >
      <h1 class>User Manager</h1>

      <div class="d-flex flex-column flex-md-row">
        <a
          :href="`/users/create`"
          class="btn btn-success mb-3 mb-md-0 ml-md-3"
        >Add</a>
      </div>
    </div>

    <div class="container-fluid mb-4 px-0">
      <div class="row mx-0">
        <div class="col-12 px-0">
          <div class="user-card hf-base-card bg-white ">
            <paginated-table
              v-if="users.data"
              :tableData="tableData"
              :paginatedData="users"
              @pagination-change-page="getUsers"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import User from '../../models/User'

export default {

    mounted() {
        console.log('mounted');
        this.getUsers();
        console.log('done');
    },
    data(){
        return {
            export: false,
            users: {},
            tableData: {
                columns: [
                    {
                        label: "ID",
                        name: "id",
                        sortable: true
                    },
                    {
                        label: "Name",
                        name: "full_name",
                        sortable: true
                    },
                    {
                        label: "Email",
                        name: "email",
                        sortable: true
                    },
                    {
                        label: "Role",
                        name: "is_admin",
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
                viewUrl: "/users",
            }
        };
    },
    methods: {


    async getUsers(
      page = 1,
      sortColumn = null,
      query = null,
      per_page = 15,
      desc = false
    ) {
        console.log('getUsers')
      let users = User.page(page).include('gyms').limit(per_page);

      if (sortColumn) {
        users.orderBy(
          (desc ? "-" : "") + (sortColumn.sort_name || sortColumn.name)
        );
      } else {
        users.orderBy("-created_at");
      }

      if (query) {
        users.where("search", query);
      }

      if (this.export) {
        users.params({
          export: true,
        });
        this.export = false;
        window.open(
          "/users" + users._builder.query(),
        //   "_blank"
        );
      }
      this.users = await users.get();
    }
  }
};
 </script>
