<template>
  <div>
    <div class="form-group">
      <router-link :to="{ name: 'createCompany' }" class="btn btn-success">Create new company</router-link>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Companies list</div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Logo</th>
              <th>Website</th>
              <th width="180">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(company, index) in companies" :key="company.id">
              <td>{{ company.name }}</td>
              <td>{{ company.email }}</td>
              <td>
                <img :src="`http://127.0.0.1:8000/storage/logos/${company.logo}`" alt="Company Logo" height="50" width="50" />
              </td>
              <td>{{ company.website }}</td>
              <td>
                <router-link :to="{ name: 'companyEdit', params: { id: company.id } }" class="btn btn-xs btn-default">Edit</router-link>
                <a href="#" class="btn btn-xs btn-danger" @click="deleteEntry(company.id, index)">Delete</a>
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
  data() {
    return {
      companies: [],
      bas_url: process.env.VUE_APP_API_URL,
      perPage: 10,
      currentPage: 1,
      totalCompanies: 0,
    };
  },
  computed: {
    pageCount() {
      return Math.ceil(this.totalCompanies / this.perPage); // Use totalCompanies for page count
    },
  },
  mounted() {
    this.fetchCompanies();
  },
  methods: {
    fetchCompanies() {
      const app = this;
      axios
        .get(process.env.VUE_APP_API_URL + 'company', {
          params: {
            page: this.currentPage,
            perPage: this.perPage,
          },
        })
        .then((resp) => {
          app.companies = resp.data.data;
          app.totalCompanies = resp.data.total;
        })
        .catch((resp) => {
          console.log(resp);
          alert("Could not load companies");
        });
    },
    deleteEntry(id, index) {
      if (confirm("Do you really want to delete it?")) {
        const app = this;
        axios
          .delete(process.env.VUE_APP_API_URL + 'company/' + id)
          .then((resp) => {
            app.companies.splice(index, 1);
            app.totalCompanies--; // Update the total company count after deletion
          })
          .catch((resp) => {
            alert("Could not delete company");
          });
      }
    },
    handlePageClick(page) {
      this.currentPage = page;
      this.fetchCompanies(); // Fetch data for the new page
    },
  },
};
</script>
