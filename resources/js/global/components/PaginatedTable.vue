<template>
  <div class="mk-paginated-table got-paginated-table">
    <div class="got-table-controls w-100">
      <div v-if="tableData.showSearch" class="w-100">
        <div class="py-3 w-100 d-flex align-items-center">
          <slot name="before-search-slot"></slot>

          <div
            class="hf-table-search-input input-group justify-content-start align-items-center mb-3 mb-md-0"
            style="max-width: 250px;"
          >
            <input
              class
              style="max-width: 200px;"
              v-model="query"
              type="text"
              placeholder="Search"
              aria-label="Search"
              @keyup.enter="getResults(1)"
            />

            <div class="input-group-append">
              <button @click="getResults(1)" class="secondary-btn ml-1 px-2" type="button">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>


          <slot name="after-search-slot"></slot>

          <div
            v-if="false"
            class="d-flex justify-content-between align-items-center ml-md-4 mb-3 mb-md-0"
            style="max-width: 160px;"
          >
            <select @change="getResults(1)" v-model="per_page">
              <option value=15>15</option>
              <option value=25>25</option>
              <option value=100>100</option>
            </select>
            <p class="mb-0 ml-md-3 text-dark-grey">Per Page</p>
          </div>

          <div class="ml-md-auto mr-md-2">
            <p class="mb-0">Total Results: {{paginatedData.total}}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive hf-paginated-table">
      <table class="table">
        <thead>
          <tr>
            <th
              v-for="(column, index) in tableData.columns"
              :key="index"
              scope="col"
              @click="onSort(column)"
              :style="[column.sortable ? {'cursor' : 'pointer !important'} : '']"
            >
              <div class="d-flex">
                <div class="d-flex flex-row-reverse mr-auto" style="min-width: 10px;">
                  <span
                    v-if="column.sortable && sortedColumn && column.name === sortedColumn.name && !desc"
                  >
                    <i class="fal fa-level-up" style="min-width: 8px;"></i>
                  </span>
                  <span
                    v-if="column.sortable && sortedColumn && column.name === sortedColumn.name && desc"
                  >
                    <i class="fal fa-level-down" style="min-width: 8px;"></i>
                  </span>

                  <span v-if="column.sortable && !sortedColumn">
                    <i class="fal fa-arrows-v" style="min-width: 8px;"></i>
                  </span>

                  <span class="mr-1">{{column.label}}</span>
                </div>
              </div>
            </th>
          </tr>
        </thead>

        <tbody v-if="paginatedData.data.length > 0">
          <tr
            class="has-interaction"
            @click="tableRowAction(data)"
            v-for="(data, index) in paginatedData.data"
            :key="index"
          >
            <!-- looped columns -->
            <td v-for="(column, index) in tableData.columns" :key="index">
              <span
                v-if="column.date"
              >{{ data[column.name] ? moment.utc(data[column.name], 'YYYY-MM-DD HH:mm:ss').local().format('DD/MM/Y') : 'N/A'}}</span>
              <span
                v-else-if="column.date_deep"
              >{{moment.utc(data[column.parent_name][column.child_name], 'YYYY-MM-DD HH:mm:ss').local().format('DD/MM/Y')}}</span>

              <span
                v-else-if="column.datetime"
              >{{moment.utc(data[column.name], 'YYYY-MM-DD HH:mm:ss').local().format('DD/MM/Y HH:mm:ss')}}</span>

              <span
                v-else-if="column.time"
              >{{moment.utc(data[column.name], 'YYYY-MM-DD HH:mm:ss').local().format('HH:mm:ss')}}</span>

              <span v-else-if="column.activity">
                <div v-if="data['custom_notes']">
                  <div style="margin-left:10px;" v-html="`${data['custom_notes']}`"></div>
                </div>

                <div
                  v-else
                  v-for="[key, value] of Object.entries(data['properties']['attributes'])"
                  :key="key"
                >
                  <div v-if="data['properties']['old']">
                    <span v-text="`${key} was changed from ` + data['properties']['old'][key]  + ` to ${value}`"></span>
                  </div>

                  <div v-else>
                    <span v-text="`${key} was set to ${value}`"></span>
                  </div>
                </div>
              </span>

              <span v-else-if="column.activity_user">
                {{ data['causer'] ? data['causer']['name'] : 'System' }}
              </span>

              <span
                v-else-if="column.boolean"
              >{{ data[column.name] ? (column.trueText || 'true') : (column.falseText || 'N/A') }}</span>

              <span v-else-if="column.downloadable">
                <a
                  class="btn-primary btn"
                  :href="data[column.name]"
                  target="_blank"
                >
                <i class="fas fa-download"></i>
                </a>
              </span>

              <span
                v-else-if="column.money"
              >{{new Intl.NumberFormat('en-AU', {style: 'currency', currency: 'AUD'}).format(Number(data[column.name]/100))}}</span>

              <span v-else-if="column.clickable">
                <button class="text-primary" @click="$parent.onClickCell(data,column.url,column.entity);">
                  {{checkPropertyExist(column.name, data)}}
                </button>
              </span>

              <span v-else-if="column.filelink">
                <button style="text-decoration: underline;" @click="$parent.showDetail(data);" >
                  {{checkPropertyExist(column.name, data)}}
                </button>
              </span>

              <span v-else-if="!column.viewable&&!column.deletable&&!column.editable">
                {{getProperty(column.name, data)}}</span>

              <!-- Actions-->
              <span v-if="column.actionable && data['custom_notes'] && (column.showDetail || column.viewable)"
                >
                <button class="icon-btn btn py-0 px-2" @click="$parent.showDetail(data);">
                  <i class="fal fa-eye"></i>
                </button>
              </span>

              <span v-else-if="column.actionable && (column.showDetail || column.viewable)">
              </span>

              <span v-else-if="column.showDetail || column.viewable">
                <button class="icon-btn btn py-0 px-2" @click="$parent.showDetail(data);">
                  <i class="fal fa-eye"></i>
                </button>
              </span>

              <span v-if="column.actionable && data['custom_notes'] && column.editable">
                <button class="icon-btn btn py-0 px-2" @click="$parent.editDetail({...data});">
                  <i class="fal fa-pen font-dark-grey"></i>
                </button>
              </span>

              <span v-else-if="column.actionable && column.editable">
              </span>

              <span v-else-if="column.editable">
                <button class="icon-btn btn py-0 px-2" @click="$parent.editDetail({...data});">
                  <i class="fal fa-pen font-dark-grey"></i>
                </button>
              </span>

              <span v-if="column.actionable && data['custom_notes'] && column.deletable">
                <button class="icon-btn btn py-0 px-2" @click="$parent.onDelete(data);">
                  <i class="fal fa-trash-alt font-dark-grey"></i>
                </button>
              </span>

              <span v-else-if="column.actionable && column.deletable">
              </span>

              <span v-else-if="column.deletable">
                <button class="icon-btn btn py-0 px-2" @click="$parent.onDelete(data);">
                  <i class="fal fa-trash-alt font-dark-grey"></i>
                </button>
              </span>

              <span v-else-if="column.multipleProperty">{{getMultipleProperties(column.name, data)}}
              </span>

            </td>
          </tr>
        </tbody>

        <tfoot v-if="tableData.totalable && paginatedData.data">
          <tr>
            <td v-for="(column, index) in tableData.columns" :key="index">
              <b>
                <span v-if="index == 0">Total: </span>
                <span v-else-if="column.totalable"> {{ getTotal(column.name) }} </span>
              </b>
            </td>
          </tr>
        </tfoot>

      </table>
    </div>

    <div class="row" v-if="paginatedData.data.length == 0">
      <div class="col-md-12 d-flex justify-content-center">
        <p>Looks like there's no data here.</p>
      </div>
    </div>

    <!-- Table pagination -->
    <div class="table-pagination-wrap">
      <p class="mb-0">PAGE {{paginatedData.current_page}} OF {{paginatedData.last_page}}</p>

      <!-- TODO: current page is an input that the user can use to change page 24-8-21 -->
      <!-- <p class="mb-0">PAGE <input v-model.number="paginatedData.current_page" type="number"> OF {{paginatedData.last_page}}</p> -->
      <pagination
        :limit="-1"
        :show-disabled="true"
        :data="paginatedData"
        @pagination-change-page="getResults"
      >
        <span slot="prev-nav">
          <i class="fas fa-chevron-left"></i>
        </span>

        <span slot="next-nav">
          <i class="fas fa-chevron-right"></i>
        </span>
      </pagination>
    </div>

  </div>
</template>

<script>
export default {
  props: {
    tableData: {
      type: Object
    },
    paginatedData: {
      type: Object
    },
    initial_query: {
      type: String
    }
  },
  data() {
    return {
      sortedColumn: null,
      query: this.initial_query,
      per_page: this.tableData.perPage ? this.tableData.perPage : 15,
      desc: true
    };
  },
  methods: {
    getResults(page = 1) {
      this.$emit(
        "pagination-change-page",
        page,
        this.sortedColumn,
        this.query,
        this.per_page,
        this.desc
      );
    },

    onSort(column) {
      if (column.sortable) {
        if (this.sortedColumn && this.sortedColumn.name == column.name) {
          this.desc = !this.desc;
        } else {
          this.desc = false;
        }
        this.sortedColumn = column;
        this.getResults(1);
      }
    },

    getMultipleProperties(propertyName, object){
      var parts = propertyName.split(','),
        length = parts.length,
        value,
        i,
        stack = [];
        for (i = 0; i < length; i++) {
          value = this.getProperty(parts[i],object);
          stack.push(value);
        }
        return stack.join(',  ');
    },

    checkPropertyExist(propertyName, object){
      var value;
        value = this.getProperty(propertyName, object);
        if (value == "N/A") {
          return  this.column.leaveEmpty ? 'N/A' : propertyName;
        } else {
          return value;
        }
    },

    getProperty(propertyName, object) {
      var parts = propertyName.split("."),
        length = parts.length,
        i,
        property = object || this;
      for (i = 0; i < length; i++) {
        property = property[parts[i]] === 0 ? "0" : property[parts[i]] || "N/A";
      }
      return property;
    },

    getTotal(columnName){
      let val = 0;
      this.paginatedData.data.forEach(data => {
        val += parseFloat(data[columnName]);
      })
      return new Intl.NumberFormat("en-AU", {
        style: "currency",
        currency: "AUD",
      }).format(val)
    },

    tableRowAction(data) {
      if (this.tableData.overrideView) {
        this.$emit("on-view", data);
      } else if (this.tableData.viewUrl && this.tableData.edit) {
        window.location.href =
          this.tableData.viewUrl +
          "/" +
          (this.tableData.overrideId
            ? data[this.tableData.overrideId]
            : data.id + "/edit");
      } else if (this.tableData.viewUrl) {
        window.location.href =
          this.tableData.viewUrl +
          "/" +
          (this.tableData.overrideId
            ? data[this.tableData.overrideId]
            : data.id);
      } else if (this.tableData.showDetail) {
        this.$parent.showDetail(data);
        // var resultData = document.getElementById("jsScrollToData");
        // resultData.scrollIntoView();
      }
    },

    selectedDate(name, date) {
      if (this.filters[name]) {
        this.filters[name].value = date;
        this.getFilters(1);
      }
    },
  },

  computed: {
    dateRange() {
      var date = new Date(),
        y = date.getFullYear(),
        m = date.getMonth();
      var firstDay = new Date(y, m, 1);

      return [
        firstDay.toISOString().substr(0, 10),
        new Date().toISOString().substr(0, 10),
      ];
    },
  },

};
</script>

<style>
</style>
