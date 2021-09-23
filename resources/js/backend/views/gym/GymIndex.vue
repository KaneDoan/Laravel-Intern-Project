<template>
  <div class="mk-be-clientindex row">
    <div
      class="px-0 col-12 d-flex flex-column flex-md-row justify-content-start justify-content-md-between align-items-md-center align-items-start"
      style="margin-bottom: 14px;"
    >
      <h1 class="ml-0 mb-0">Gyms</h1>

      <div class="d-flex flex-column flex-md-row">
        <a
          :href="`/gyms/create`"
          class="btn btn-success mb-3 mb-md-0 ml-md-3"
        >Create New</a>
        <button
          @click="getExport"
          class="btn-primary ml-md-3"
        >Export</button>
      </div>
    </div>

    <div class="container-fluid mb-4 px-0">
      <div class="row mx-0">
        <div class="col-12 px-0">
          <div class="client-card hf-base-card bg-white ">
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
import Gym from "../../models/Gym";

export default {
  async mounted() {
     this.getGyms();
  },
  data() {
    return {
      export: false,
      clients: {},
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
            name: "last_name",
            sortable: false
          },
          {
            label: "Mobile No",
            name: "phone",
            sortable: false
          },
          {
            label: "Suburb",
            name: "address_city",
            sortable: false
          },
          {
            label: "State",
            name: "address_state",
            sortable: false
          },
          {
            label: "Client Type",
            name: "client_type.name",
            sortable: false
          },
          {
            label: "Status",
            name: "client_status.name",
            sortable: false
          },
          {
            label: "Created At",
            name: "created_at",
            sortable: true,
            date: true,
          }
        ],
        edit: true,
        showSearch: true,
        showPerPage: false,
        viewUrl: "/gyms"
      }
    };
  },
  methods: {
    getExport() {
      this.export = true;
      this.getClients(1);
    },

    async getClients(
      page = 1,
      sortColumn = null,
      query = null,
      per_page = 15,
      desc = false
    ) {
      let clients = Client.page(page).include('clientType', 'clientStatus', 'source').limit(per_page);

      if (sortColumn) {
        clients.orderBy(
          (desc ? "-" : "") + (sortColumn.sort_name || sortColumn.name)
        );
      } else {
        clients.orderBy("-created_at");
      }

      if (query) {
        clients.where("search", query);
      }

      if (this.export) {
        clients.params({
          export: true,
        });
        this.export = false;
        window.open(
          "/admin/clients/export" + clients._builder.query(),
          "_blank"
        );
      }

      this.clients = await clients.get();
      //console.log(clients.data);
    }
  }
};
</script>
