<template>
  <div>
    <div class="form-group">
      <router-link to="/" class="btn btn-default">Back</router-link>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading ">Create new company</div>
      <div class="panel-body">
        <form @submit.prevent="saveForm">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Company name</label>
              <input type="text"   v-model="company.name" required class="form-control">
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
              <button type="submit" class="btn btn-success">Create</button>
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
  data() {
    return {
      company: {
        name: '',
        email: '',
        logo: null,
        website: '',
       
      },
    };
  },
  methods: {
    handleFileChange(event) {
      this.company.logo = event.target.files[0];
    },
    saveForm() {
      const formData = new FormData();
      formData.append('name', this.company.name);
      formData.append('email', this.company.email);
      formData.append('website', this.company.website);
      formData.append('logo', this.company.logo);

      axios
        .post(process.env.VUE_APP_API_URL + 'company', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then((response) => {
          this.$router.push({ path: '/companies' });
        })
        .catch((error) => {
          console.error(error);
          alert('Could not create your company');
        });
    },
  },
};
</script>
