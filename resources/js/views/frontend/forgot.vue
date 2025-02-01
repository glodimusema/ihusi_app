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
                         <div>
                              <h4>Recupération mot de passe</h4>
                              <p>
                                  Si vous avez oublié votre mot de passe, 
                                  nous vous enverrons par e-mail des instructions pour réinitialiser
                                   votre mot de passe.
                              </p>
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
                       
                       

                        <v-btn
                          dark
                          color="primary"
                          block
                          :disabledb="!valid"
                          @click="validate"
                          ><v-icon>language</v-icon> Renvoyer le lien</v-btn
                        >

                        <br />

                        Je ne l'ai pas oublié?
                        <a
                          @click="gotoPage('')"
                          style="text-decoration: none"
                          >Se connecter</a
                        >

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
        email: ""
      },
      valid: false,
      diaL: false,
      show1: false,
      titre: "Recupération de mot de passe",
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
          `${this.baseURL}/reset_password_without_token`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
             this.diaL = false;
            this.resetObj(this.svData);
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
