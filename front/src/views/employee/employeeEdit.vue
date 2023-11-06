<template>
  <div>
    <div class="form-group">
      <router-link to="/employees" class="btn btn-default">Back</router-link>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Edit Employee</div>
      <div class="panel-body">
        <form @submit.prevent="saveForm">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Employee First name</label>
              <input type="text" v-model="employee.first_name" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Employee Last name</label>
              <input type="text" v-model="employee.last_name" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Company</label>
            <select v-model="employee.company_id" class="form-control">
            <option value="">Select a Company</option>
     <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }}</option>
   </select>

            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Employee Email</label>
             <input type="text" v-model="employee.email" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Employee Phone</label>
              <input type="text" v-model="employee.phone" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group">
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
import axios from 'axios';

export default {
  data: function () {
    return {
      employeeId: null,
      employee: {
        first_name: '',
        last_name: '',
        company_id: '', 
        email: '',
        phone: '',
      },
      companies: [],
    };
  },
  mounted() {
    const app = this;
    let id = app.$route.params.id;
    app.employeeId = id;
    axios.get(process.env.VUE_APP_API_URL + 'employee/' + id)
      .then(function (resp) {
        app.employee = resp.data.data;
      })
      .catch(function () {
        alert("Could not load your employee");
      });

    axios.get(process.env.VUE_APP_API_URL + 'company')
      .then(function (resp) {
        app.companies = resp.data.data;
      })
      .catch(function (resp) {
        console.log(resp);
        alert("Could not load employes");
      });
  },
  methods: {
    saveForm() {
      let app = this;
      axios.put(process.env.VUE_APP_API_URL + 'employee/' + app.employeeId, app.employee)
        .then(function (resp) {
          app.$router.push({ path: '/employees' });
        })
        .catch(function (resp) {
          console.log(resp);
          alert("Could not save the employee");
        });
    },
  },
};
</script>
