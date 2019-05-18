<template>
  <div
    class="modal fade"
    id="LoginModalComponent"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class=" list-group alert alert-danger " v-if="errors.length > 0">

            <li class="list-group-item" v-for="error in errors" :key="errors.indexOf(error)">
                {{ error }}
            </li>

          </ul>
          <form>
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" name="email" v-model="email">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" id class="form-control" v-model="password">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button
            type="button"
            class="btn btn-primary"
            @click="attemptLogin()"
            :disabled="!isValidLoginForm"
          >Login</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",
      loading: false,
      errors: []
    };
  },

  methods: {
    emailIsValid() {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {
        return true;
      } else {
        return false;
      }
    },
    attemptLogin() {
      
      this.errors = [];

      this.loading = true;

      axios
        .post("/login", {
          email: this.email,
          password: this.password
        })
        .then(resp => {
          location.reload();
        })
        .catch(error => {
          this.loading = false;

          if (error.response.status == 422) {
            this.errors.push("Sorry! We could'nt verify your account details");
          } else {
            this.errors.push("Something went wrong. Please try again");
          }
        });
    }
  },

  computed: {
    isValidLoginForm() {
      return this.emailIsValid() && this.password && !this.loading;
    }
  }
};
</script>
