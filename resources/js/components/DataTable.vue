<template>
  <!--  Per page and search starts -->
  <div class="row mb-3">
    <div class="col-md-3">
      <div class="input-group">
        <input
            v-model="search"
            class="form-control"
            placeholder="Search..."
            type="text"
        />
        <div class="input-group-append">
          <button class="btn btn-dark" type="button" @click.prevent="handleSearch">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="input-group">
        <label class="mt-2 mr-2" for="pageOption">Per page</label>
        <select id="pageOption" v-model="perPage" class="form-control" @change="handlePerPage">
          <option v-for="page in pageOptions" :key="page" :value="page">{{ page }}</option>
        </select>
      </div>

    </div>
  </div>
  <!--  Per page ends here -->
  <table class="table table-hover">
    <thead class="thead-dark">
    <tr>
      <th v-for="column in columns" scope="col" @click="updateSortColumn(column)">{{ column.toUpperCase().replace('_', ' ') }}
        <span v-if="column === sortField">
                            <i v-if="sortOrder === 'asc' " class="fa fa-arrow-up"></i>
                            <i v-else class="fa fa-arrow-down"></i>
            </span>
      </th>
    </tr>
    </thead>
    <tbody>
    <tr v-if="tableData.length === 0">No Records found</tr>
    <tr v-for="data in tableData" v-else>
      <td v-for="column in columns">{{ data[column] }}</td>
    </tr>
    </tbody>
  </table>
  <!--  Paginator goes here-->
  <paginator v-if="tableData.length > 0"
             :pagination="pagination"
             :totalItems = "tableData.length"
             @pageChanged="handlePageChange"
  />
</template>

<script>
import Paginator from './Paginator'

export default {
  name: 'DataTable',
  components: { Paginator },
  data () {
    return {
      tableData: [],
      sortField: this.columns[0],
      sortOrder: 'asc',
      search: null,
      pageOptions: [5, 10, 20, 50],
      perPage: 5,
      page: 1,
      pagination: { to: 1, from: 1 },
    }
  },
  props: {
    url: { type: String, required: true },
    columns: { type: Array, required: true },
  },
  created () {
    this.fetchData()
  },
  methods: {
    async fetchData () {
      try {
        const params = {
          sort_field: this.sortField,
          sort_order: this.sortOrder,
          search: this.search,
          per_page: this.perPage,
          page: this.page
        }
        const { data } = await axios.get(this.url, { params })
        this.tableData = data.data
        this.pagination = data.meta
      } catch (e) {
        console.log(e)
        alert('There is error')
      }
    },
    updateSortColumn (column) {
      if (column === this.sortField) {
        this.sortOrder = (this.sortOrder === 'asc') ? 'desc' : 'asc'
      } else {
        this.sortField = column
        this.sortOrder = 'asc'
      }
      this.fetchData()
    },
    handleSearch () {
      this.sortField = this.columns[0]
      this.sortOrder = "asc"
      this.page = 1
      this.fetchData()
    },
    handlePerPage ($event) {
      this.page = 1
      this.perPage = $event.target.value
      this.fetchData()
    },
    handlePageChange(pageNumber) {
      this.page = pageNumber
      this.fetchData()
    }
  },
}
</script>

<style scoped>

</style>
