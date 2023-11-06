<template>
  <div>
    <div class="form-group">
      <router-link to="/" class="btn btn-default">Back</router-link>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Edit Company</div>
      <div class="panel-body">
        <form @submit.prevent="saveForm">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Company name</label>
              <input type="text" v-model="company.name" required class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Company email</label>
              <input type="text" v-model="company.email" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Logo</label>
              <input type="file" @change="handleFileChange" class="form-control-file">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Company website</label>
              <input type="text" v-model="company.website" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group">
              <button type="submit" class="btn btn-success">Update</button>
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
  mounted() {
    let app = this;
    let id = app.$route.params.id;
    app.companyId = id;
    axios.get(process.env.VUE_APP_API_URL + 'company/' + id)
      .then(function (resp) {
        app.company = resp.data.data;
      })
      .catch(function () {
        alert("Could not load your company");
      });
  },
  data: function () {
    return {
      companyId: null,
      company: {
        name: '',
        website: '',
        email: '',
        logo: null,
      }
    }
  },
  methods: {
    handleFileChange(event) {
      this.company.logo = event.target.files[0];
    },
    saveForm() {
      var app = this;
      var formData = new FormData();
      for (let key in app.company) {
        formData.append(key, app.company[key]);
      }
      axios.patch(process.env.VUE_APP_API_URL + 'company/' + app.companyId, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then(function (resp) {
          app.$router.replace('/companies');
        })
        .catch(function (resp) {
          console.log(resp);
          alert("Could not update your company");
        });
    }
  }
}
</script>
