<template>
  <div>
    <div class="form-group">
      <router-link :to="{ name: 'employeeCreate' }" class="btn btn-success">Create Employee</router-link>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Employees list</div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Company</th>
              <th>Email</th>
              <th>Phone</th>
              <th width="180">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(employee, index) in employees" :key="employee.id">
              <td>{{ employee.first_name }}</td>
              <td>{{ employee.last_name }}</td>
              <td>{{ employee.company ? employee.company.name : '' }}</td>
              <td>{{ employee.email }}</td>
              <td>{{ employee.phone }}</td>
              <td>
                <router-link :to="{ name: 'employeeEdit', params: { id: employee.id } }" class="btn btn-xs btn-default">
                  Edit
                </router-link>
                <a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(employee.id, index)">
                  Delete
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <paginate
      :page-count="pageCount"
      :prev-text="'Previous'"
      :next-text="'-Next'"
      container-class="pagination"
      :click-handler="handlePageClick"
    ></paginate>
  </div>
</template>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
import axios from 'axios';
import Paginate from 'vuejs-paginate';

export default {
  components: {
    Paginate,
  },
  data: function () {
    return {
      employees: [],
      perPage: 10,
      currentPage: 1,
    };
  },
  computed: {
    pageCount() {
      return Math.ceil(this.totalItems / this.perPage);
    },
  },
  mounted() {
    this.fetchEmployees();
  },
  methods: {
    fetchEmployees() {
      const app = this;
      const page = app.currentPage;
      axios
        .get(process.env.VUE_APP_API_URL + 'employee', {
          params: {
            page: page,
          },
        })
        .then(function (resp) {
          app.employees = resp.data.data;
          app.totalItems = resp.data.total;
        })
        .catch(function (resp) {
          console.log(resp);
          alert('Could not load employees');
        });
    },
    deleteEntry(id, index) {
      if (confirm('Do you really want to delete it?')) {
        const app = this;
        axios
          .delete(process.env.VUE_APP_API_URL + 'employee/' + id)
          .then(function (resp) {
            app.employees.splice(index, 1);
          })
          .catch(function (resp) {
            alert('Could not delete employee');
          });
      }
    },
    handlePageClick(page) {
      this.currentPage = page;
      this.fetchEmployees(); // Fetch data for the new page
    },
  },
};
</script>
