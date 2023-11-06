<template>
  <div>
    <div class="form-group">
      <router-link to="/employees" class="btn btn-default">Back</router-link>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Create Employee</div>
      <div class="panel-body">
        <form v-on:submit="saveForm">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Employee First name</label>
              <input type="text" v-model="employee.first_name" required class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Employee Last name</label>
              <input type="text" v-model="employee.last_name" required class="form-control">
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
              <button class="btn btn-success">Create</button>
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
                employee: {
                    first_name: '',
                    last_name: '',
                    company_id: '',
                    email: '',
                    phone: '',
                },
                companies:[]
            }
        },

    mounted() {
    const app = this;
    axios
      .get(process.env.VUE_APP_API_URL + 'company')
      .then((resp) => {
        console.log(resp.data.data);
        app.companies = resp.data.data;
      })
      .catch((resp) => {
        console.log(resp);
        alert("Could not load companies");
      });
  },
        methods: {
        
            saveForm() {
                event.preventDefault();
                var app = this;
                var newEmployee = app.employee;
                axios.post(process.env.VUE_APP_API_URL +'employee', newEmployee)
                    .then(function (resp) {
                        app.$router.push({path: '/employees'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your company");
                    });
            }
        }
    }
</script>