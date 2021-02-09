<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li
          :class="{ 'disabled' : pagination.current_page === 1}"
          class="page-item"
      >
        <a class="page-link" href="#" @click.prevent="changePage(1)">First</a>
      </li>
      <li
          :class="{ 'disabled' : pagination.current_page === 1}"
          class="page-item"
      >
        <a
            class="page-link"
            href="#"
            @click.prevent="changePage(pagination.current_page - 1)">
          Previous
        </a>
      </li>
      <li
          v-for="pageNumber in pagesNumbers"
          :class="{ 'active' : pageNumber === pagination.current_page }"
          class="page-item"
          @click.prevent="changePage(pageNumber)"
      >
        <a class="page-link" href="#" v-text="pageNumber"></a>
      </li>
      <li
          :class="{ 'disabled' : pagination.current_page === pagination.last_page}"
          class="page-item"
      >
        <a class="page-link"
           href="#"
           @click.prevent="changePage(pagination.current_page + 1)">
          Next
        </a>
      </li>
      <li
          :class="{ 'disabled' : pagination.current_page === pagination.last_page}"
          class="page-item"
      >
        <a class="page-link" href="#" @click.prevent="changePage(pagination.last_page)">Last</a>
      </li>
      <span class="mt-2 ml-2">
        <i>Showing {{ totalItems }} of {{ pagination.total }} entries.</i>
      </span>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'Paginator',
  data () {
    return {
      offset: 4,
    }
  },
  props: {
    totalItems: {type: Number, required: true},
    pagination: { type: Object, required: true },
  },
  computed: {
    pagesNumbers () {
      let pages = []
      const { last_page, current_page, from, to} = this.pagination
      if (!to) return []
      let fromPage = current_page - this.offset
      if (fromPage < 1) fromPage = 1
      let toPage = fromPage + (this.offset * 2)
      if (toPage >= last_page) {
        toPage = last_page
      }
      for (let page = fromPage; page <= toPage; page++) {
        pages.push(page)
      }
      return pages
    },
  },
  methods: {
    changePage (pageNumber) {
      this.$emit('pageChanged', pageNumber)
    },
  },
}
</script>

<style scoped>

</style>
