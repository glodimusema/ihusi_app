<template>
  <div>
    <!-- App.vue -->

    <v-app>
      <!-- Sizes your content based upon application components -->
      <v-main>
        <!-- Provides the application the proper gutter -->
        <v-container fluid>
          
          <!-- form -->

          <br />
          <v-layout row wrap>
            <v-flex x12 md4></v-flex>
            <v-flex x12 md4>
              <v-card class="elevation-12">
                
                <v-card-text>
                  
                  <v-layout row wrap>
                    <v-flex x12 md2></v-flex>
                    <v-flex x12 md8>
                      <v-form
                        ref="form"
                        v-model="valid"
                        lazy-validation
                        autocomplete="off"
                      >
                        <div
                          align="center"
                          style="cursor: pointer"
                          class="headline"
                          tile
                        >
                          <br />
                          <v-avatar
                            size="150"
                            color="light-green lighten-5"
                          >
                            <img
                              style=""
                              :src="`${baseURL}/images/logo.png`"
                              alt=""
                              width="100%"
                            />
                          </v-avatar>
                        </div> 
                        <br />
                        <v-text-field
                          v-model="svData.email"
                          outlined
                          append-icon="email"
                          :rules="[
                            (v) => !!v || 'Ce champ est requis',
                            (v) =>
                              /.+@.+\..+/.test(v) ||
                              'Doit être un email valide',
                          ]"
                          placeholder="E-mail"
                        ></v-text-field>
                        <v-text-field
                          placeholder="Password"
                          v-model="svData.password"
                          :type="show1 ? 'text' : 'password'"
                          outlined
                          :append-icon="show1 ? 'visibility' : 'visibility_off'"
                          :rules="[(v) => !!v || 'Ce champ est requis']"
                          @click:append="show1 = !show1"
                        ></v-text-field>

                        <v-checkbox
                          label="Mot de passe oublié?"
                          @click="gotoPage('forgot')"
                          @blur="$v.checkbox.$touch()"
                        ></v-checkbox>

                        <v-btn
                          dark
                          color="primary"
                          block
                          :disabledb="!valid"
                          @click="validate"
                          ><v-icon>login</v-icon> Connexion</v-btn
                        >

                        <br />

                        <!-- Avez-vous un compte?
                        <a
                          @click="gotoPage('registerEntreprise')"
                          style="text-decoration: none"
                          >Créer un compte</a
                        > -->

                        <br />
                        <br />
                      </v-form>
                    </v-flex>
                    <v-flex x12 md2></v-flex>
                  </v-layout>
                </v-card-text>
              </v-card>
            </v-flex>
            <v-flex x12 md4></v-flex>
          </v-layout>
          <dialogLoader v-if="diaL" />

          <!-- fin form -->

          <!-- If using vue-router -->
          <!-- <router-view></router-view> -->
        </v-container>
      </v-main>
    </v-app>
  </div>
</template>

<script>
import dialogLoader from "./dialogLoader";
export default {
  components: {
    dialogLoader,
  },
  data() {
    return {
      svData: {
        email: "",
        password: "",
      },
      valid: false,
      diaL: false,
      show1: false,
      titre: "Connexion et authentification au système",
    };
  },
  methods: {
    showModal() {
      this.$refs.presentation.$data.dialog = true;
    },
    validate() {
      if (this.$refs.form.validate()) {
        this.diaL = true;
        this.insertOrUpdate(
          `${this.baseURL}/checkLogin`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            if (data.wrong) {
              this.showError("Information incorrecte");
              this.diaL = false;
            }
            if (data.wrong == false) {

               this.diaL = false;

               window.location = `${this.baseURL}/dashbord`;
            }
          })
          .catch((error) => {
            error.response.status === 419
              ? window.location.reload()
              : this.svErr(),
              (this.diaL = false),
              (this.diaL = false);
          });
      }
    },
   
  },
};
</script>
