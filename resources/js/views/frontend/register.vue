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
                        <br />
                        <v-text-field
                          label="Nom"
                          append-icon="person"
                          :rules="[(v) => !!v || 'Ce champ est requis']"
                          outlined
                          v-model="svData.name"
                        ></v-text-field>

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

                        <v-select
                          :items="[{ designation: 'M' }, { designation: 'F' }]"
                          label="Sexe"
                          append-icon="wc"
                          :rules="[(v) => !!v || 'Ce champ est requis']"
                          outlined
                          dense
                          item-text="designation"
                          item-value="designation"
                          v-model="svData.sexe"
                        ></v-select>

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
                          :rules="[
                            (v) => !!v || 'Vous devez accepter de continuer!',
                          ]"
                          label="J'accepte Politique de confidentialité"
                          required
                        ></v-checkbox>

                        <v-btn
                          dark
                          
                          color="primary"
                          block
                          :disabledb="!valid"
                          @click="validate"
                          >
                          <v-icon>save_alt</v-icon>
                          S'ENREGISTRER
                          </v-btn
                        >

                        <br />

                        J'ai déjà un compte?
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
        id: "",
        name: "",
        email: "",
        password: "",
        sexe: "",
      },
      valid: false,
      diaL: false,
      show1: false,
      titre:
        "Devenir à présent membre au système en créant un compte utilisateur",
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
          `${this.baseURL}/register_count`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            // console.log(data.data);

            this.showMsg(data.data);
            this.isLoading(false);
            // this.resetObj(this.svData);

            if (data.success == false) {
              this.showError("Information incorrecte");
              this.diaL = false;
            }
            if (data.success == true) {
              window.location = `${this.baseURL}/login`;
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
