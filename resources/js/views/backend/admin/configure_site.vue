<template>
  <v-layout>
    <v-flex md12>
      <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
        persistent
      >
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              {{ titleComponent }} <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog = false" text fab depressed>
                      <v-icon>close</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Fermer</span>
              </v-tooltip></v-card-title
            >
            <v-card-text max-height="1000px">
              <v-layout row wrap>
                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="Nom"
                      prepend-inner-icon="person"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.nom"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="Email"
                      prepend-inner-icon="email"
                      :rules="[
                        (v) => !!v || 'Ce champ est requis',
                        (v) =>
                          /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                      ]"
                      outlined
                      v-model="svData.email"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <v-textarea
                      label="Description"
                      rows="1"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      prepend-inner-icon="mdi-comment"
                      outlined
                      v-model="svData.description"
                    ></v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="Adresse"
                      prepend-inner-icon="person"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.adresse"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="N° de Téléphone principal"
                      prepend-inner-icon="phone_iphone"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.tel1"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="N° de Téléphone"
                      prepend-inner-icon="phone_iphone"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.tel2"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="N° de Téléphone des sms API"
                      prepend-inner-icon="phone_iphone"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.tel3"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="Token"
                      prepend-inner-icon="token"
                      outlined
                      v-model="svData.token"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="Facebook"
                      prepend-inner-icon="travel_explore"
                      outlined
                      v-model="svData.facebook"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="Twitter"
                      prepend-inner-icon="travel_explore"
                      outlined
                      v-model="svData.twitter"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md6 sm6 lg6>
                  <div class="mr-1">
                    <v-text-field
                      label="Linkedin"
                      prepend-inner-icon="travel_explore"
                      outlined
                      v-model="svData.linkedin"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <v-text-field
                      label="Youtube"
                      prepend-inner-icon="travel_explore"
                      outlined
                      v-model="svData.youtube"
                    ></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <v-textarea
                      label="Mission"
                      rows="1"
                      prepend-inner-icon="open_in_new"
                      outlined
                      v-model="svData.mission"
                    ></v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <v-textarea
                      label="Objectif"
                      rows="1"
                      prepend-inner-icon="open_in_new"
                      outlined
                      v-model="svData.objectif"
                    ></v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <v-textarea
                      label="Politique de confidentialité"
                      rows="1"
                      prepend-inner-icon="open_in_new"
                      outlined
                      v-model="svData.politique"
                    ></v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <v-textarea
                      label="Condition d'utilisation"
                      rows="1"
                      prepend-inner-icon="open_in_new"
                      outlined
                      v-model="svData.condition"
                    ></v-textarea>
                  </div>
                </v-flex>
              </v-layout>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
              <v-btn color="primary" dark :loading="loading" @click="validate">
                {{ edit ? "Modifier" : "Ajouter" }}
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>
      <br /><br />
      <v-layout>
        <v-layout>
          <v-flex md1></v-flex>
          <v-flex md10></v-flex>
          <v-flex md1></v-flex>
        </v-layout>

        <v-flex md12>
          <!-- bande -->
          <v-layout>
            <v-flex md1>
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn :loading="loading" fab @click="onPageChange">
                      <v-icon>autorenew</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Initialiser</span>
              </v-tooltip>
            </v-flex>
            <v-flex md6>
              <v-text-field
                append-icon="search"
                label="Recherche..."
                single-line
                solo
                outlined
                rounded
                hide-details
                v-model="query"
                @keyup="searchMember"
                clearable
              ></v-text-field>
            </v-flex>

            <v-flex md4></v-flex>

            <v-flex md1>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="showModal" fab color="primary">
                      <v-icon>add</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Ajouter une opération</span>
              </v-tooltip>
            </v-flex>
          </v-layout>
          <!-- bande -->

          <br />
          <v-card :loading="loading" :disabled="isloading">
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Avatar</th>
                      <th class="text-left">Nom</th>
                      <th class="text-left">Email</th>
                      <th class="text-left">Description</th>
                      <th class="text-left">Adresse</th>
                      <th class="text-left">Téléphone</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>
                        <!-- <v-avatar color="red">
                          <span class="white--text text-h5">
                            {{ item.name | subStr }}
                          </span>
                        </v-avatar> -->

                        <!-- image -->
                        <img
                          style="border-radius: 50px; width: 50px; height: 50px"
                          :src="
                            item.logo == null
                              ? `${baseURL}/images/avatar.png`
                              : `${baseURL}/images/` + item.logo
                          "
                        />
                        <!-- images -->
                      </td>
                      <td>{{ item.nom }}</td>
                      <td>{{ item.email }}</td>
                      <td>{{ item.description | subStrLong }}</td>
                      <td>{{ item.adresse }}</td>
                      <td>{{ item.tel1 }}</td>

                      <td>
                        <v-tooltip top color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="editData(item.id)" fab small
                                ><v-icon color="primary">edit</v-icon></v-btn
                              >
                            </span>
                          </template>
                          <span>Modifier</span>
                        </v-tooltip>

                        <v-tooltip top color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="clearP(item.id)" fab small
                                ><v-icon color="red">delete</v-icon></v-btn
                              >
                            </span>
                          </template>
                          <span>Supprimer</span>
                        </v-tooltip>

                        <v-tooltip top color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn
                                @click="showPhotoModal(item.id, item.logo)"
                                fab
                                small
                              >
                                <v-icon>perm_media</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Modifier l'image</span>
                        </v-tooltip>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <hr />

              <v-pagination
                color="primary"
                v-model="pagination.current"
                :length="pagination.total"
                @input="onPageChange"
              ></v-pagination>
            </v-card-text>
          </v-card>
          <!-- les composants -->
          <uploadImage ref="uploadImage" />

          <!-- fin des composants -->
        </v-flex>
      </v-layout>
    </v-flex>
  </v-layout>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import uploadImage from "./logo_site.vue";

export default {
  components: {
    uploadImage,
  },
  data() {
    return {
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      svData: {
        id: "",
        nom: "",
        email: "",
        description: "",
        adresse: "",

        token: "",
        tel1: "",
        tel2: "",
        tel3: "",
        about: "",
        mission: "",
        objectif: "",
        politique: "",
        condition: "",
        facebook: "",
        linkedin: "",
        twitter: "",
        youtube: "",
      },
      fetchData: null,
      titreModal: "",
    };
  },

  computed: {
    ...mapGetters(["siteList", "isloading"]),
  },
  methods: {
    ...mapActions(["getSite"]),

    showPhotoModal(id, avatar) {
      this.$refs.uploadImage.$data.dialog = true;
      this.$refs.uploadImage.$data.svData.agentId = id;
      this.$refs.uploadImage.$data.image = avatar;
    },

    showModal() {
      this.dialog = true;
      this.titleComponent = "Configuration site ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification du site ";
      } else {
        this.titleComponent = "Configuration site ";
      }
    },

    searchMember: _.debounce(function () {
      this.onPageChange();
    }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_site?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_site`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.getSite();
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_site/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.id = item.id;
            this.titleComponent = "modification du site ";
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_site/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },

    editTitleModal(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_site/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.titleComponent = "modification du site ";
          });
        }
      );
    },
  },
  created() {
    this.getSite();
    this.testTitle();
    this.onPageChange();
  },
};
</script>