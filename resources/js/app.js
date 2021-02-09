require('./bootstrap')
import { createApp } from 'vue'
import DataTable     from './components/DataTable'

createApp({
  components: {
    DataTable,
  },
}).mount('#app')
