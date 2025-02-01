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
                          <h4>Reinitialisation de mot de passe</h4>
                          <p>
                            vous êtes au bout de réunitialisation de mot de
                            passe; prière d'entrer les bonnes bonnes
                            informations secretes.
                          </p>
                        </div>
                        <br />
                        <v-text-field
                          placeholder="Nouveau mot de passe"
                          v-model="svData.password"
                          :type="show1 ? 'text' : 'password'"
                          outlined
                          :append-icon="show1 ? 'visibility' : 'visibility_off'"
                          :rules="[(v) => !!v || 'Ce champ est requis']"
                          @click:append="show1 = !show1"
                        ></v-text-field>

                        <v-text-field
                          placeholder="Confirmer le mot de passe"
                          v-model="svData.password2"
                          :type="show1 ? 'text' : 'password'"
                          outlined
                          :append-icon="show1 ? 'visibility' : 'visibility_off'"
                          :rules="[(v) => !!v || 'Ce champ est requis']"
                          @click:append="show1 = !show1"
                        ></v-text-field>

                        <v-btn
                          dark
                          color="primary"
                          block
                          :disabledb="!valid"
                          @click="validate"
                          ><v-icon>language</v-icon> Le Restaurer
                        </v-btn>

                        <br />

                        <a
                          @click="gotoPage('login')"
                          style="text-decoration: none"
                          >Revenir à la connexion</a
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
  props: {
    token: String,
    email: String,
  },
  data() {
    return {
      svData: {
        email: "",
        token: "",
        password: "",
        password2: "",
      },
      valid: false,
      diaL: false,
      show1: false,
      titre: "Recupération de mot de passe",
    };
  },
  created() {
    this.showDatas();
  },
  methods: {
    showModal() {
      this.$refs.presentation.$data.dialog = true;
    },
    validate() {
      if (this.$refs.form.validate()) {
        this.diaL = true;

        var verification = this.testChamps();
        if (verification) {
          if (this.svData.password == this.svData.password2) {
            this.insertOrUpdate(
              `${this.baseURL}/reset_password_with_token`,
              JSON.stringify(this.svData)
            )
              .then(({ data }) => {
                this.showMsg(data.data);
                this.diaL = false;

                if (data.success == false) {
                    this.showError("Information incorrecte");
                    this.diaL = false;
                }
                if (data.success == true) {
                    window.location = `${this.baseURL}/login`;
                }


                this.resetObj(this.svData);
              })
              .catch((error) => {
                error.response.status === 419
                  ? window.location.reload()
                  : this.svErr(),
                  (this.diaL = false),
                  (this.diaL = false);
              });
          } else {
            this.showError("Les deux mot de passe doivent être identiques!!!");
            this.diaL = false;
          }
        } else {
          this.showError("Veillez Complètez tous les champs!!!");
          this.diaL = false;
        }
      }
    },

    showDatas() {
      this.svData.token = this.token;
      this.svData.email = this.email;
      console.log("token:" + this.svData.token + " email:" + this.svData.email);
    },

    testChamps() {
      if (
        this.svData.token != "" &&
        this.svData.email != "" &&
        this.svData.password != "" &&
        this.svData.password2 != ""
      ) {
        return true;
      } else {
        return false;
      }
    },
  },
};
</script>
