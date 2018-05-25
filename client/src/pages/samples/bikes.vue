<template>
  <q-table
    title="Atlanta Bikeshare API"
    :data="bikeData"
    :columns="columns"
    row-key="name"
  />
</template>


<!--

https://api.coord.co/v1/bike/location?access_key=p9H_wRiQaoEoIKQBaJnA1oR77yCBY-6Z-AEku8bgJNk&latitude=33.7490&longitude=-84.3880&radius_km=10


Pull first array (row) and get all the columns from the keys

Object.keys

https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys

// array like object
var obj = { 0: 'a', 1: 'b', 2: 'c' };
console.log(Object.keys(obj)); // console: ['0', '1', '2']

foreach over array

Created "columns" array from the array of keys.
-->

<script>
import axios from 'axios'
import tableData from 'assets/table-data'
export default {
  data () {
    return {
      bikeData: [], 
      tableData,
      columns: [
        {
          name: 'name',
          required: false,
          label: 'Name',
          align: 'left',
          field: 'name',
          sortable: true
        },
        {
          name: 'bikes',
          required: false,
          label: 'Bikes',
          align: 'left',
          field: 'bikes',
          sortable: true
        },
        {
          name: 'openDocks',
          required: false,
          label: 'Open Docks',
          align: 'left',
          field: 'openDocks',
          sortable: true
        },
        {
          name: 'reported',
          required: false,
          label: 'Reported',
          align: 'left',
          field: 'reported',
          sortable: true
        },
        {
          name: 'locationID',
          required: false,
          label: 'Location ID',
          align: 'left',
          field: 'locationID',
          sortable: true
        },
        {
          name: 'regionID',
          required: false,
          label: 'Region ID',
          align: 'left',
          field: 'regionID',
          sortable: true
        },
        {
          name: 'systemID',
          required: false,
          label: 'System ID',
          align: 'left',
          field: 'systemID',
          sortable: true
        }
      ],
      filter: '',
      visibleColumns: ['desc', 'fat', 'carbs', 'protein', 'sodium', 'calcium', 'iron'],
      separator: 'horizontal',
      selection: 'multiple',
      selected: [
        // initial selection
        { name: 'Ice cream sandwich' }
      ],
      pagination: {
        page: 2
      },
      paginationControl: { rowsPerPage: 7, page: 1 },
      loading: false,
      dark: true,
      selectedSecond: [
        { name: 'Eclair' }
      ]
    }
  },
  watch: {
    'paginationControl.page' (page) {
      this.$q.notify({
        color: 'secondary',
        message: `Navigated to page ${page}`,
        actions: page < 4
          ? [{
            label: 'Go to last page',
            handler: () => {
              this.paginationControl.page = 4
            }
          }]
          : null
      })
    }
  },
  computed: {
    tableClass () {
      if (this.dark) {
        return 'bg-black'
      }
    }
  },
  mounted () {
    this.getData();
  },
  methods: {
    getData () {
      let _this = this;
      const LATITUDE = 33.7490; // String Literal
      const LONGITUDE = -84.3880;
      axios.get(`https://api.coord.co/v1/bike/location?access_key=p9H_wRiQaoEoIKQBaJnA1oR77yCBY-6Z-AEku8bgJNk&latitude=${LATITUDE}&longitude=${LONGITUDE}&radius_km=10`)
      .then(function (response) {
        console.log(response);
        let tableData = [];
        response.data.features.forEach(item => {
          tableData.push({
            name: item.properties.name,
            bikes: item.properties.num_bikes_available,
            openDocks: item.properties.num_docks_available,
            reported: item.properties.last_reported,
            systemID: item.properties.system_id,
            locationID: item.properties.location_id,
            regionID: item.properties.region_id
          });
        });
        _this.bikeData = tableData;
      })
    },
    deleteRow () {
      this.$q.notify({
        color: 'secondary',
        icon: 'delete',
        message: `Will delete the selected row${this.selectedSecond.length > 1 ? 's' : ''} later, ok?`
      })
    }
  }
}
</script>
