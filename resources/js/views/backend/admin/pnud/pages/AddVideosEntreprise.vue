<template>
  <v-layout>
    <v-flex md12>
      <v-dialog
        v-model="dialog"
        max-width="600"
        hide-overlay
        transition="dialog-bottom-transition"
        persistent
      >
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title class="text-h6 primary">
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
              <v-container>
                <v-layout row wrap class="mt-2">
                  <v-flex xs12 md12 sm12 lg12>
                    <v-text-field
                      label="Le titre de la vidéo"
                      prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.titre"
                      dense
                    ></v-text-field>
                  </v-flex>

                  <v-flex xs12 md12 sm12 lg12>
                    <v-text-field
                        label="L'adresse url de la vidéo"
                        type="url"
                        prepend-inner-icon="link"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined
                        v-model="svData.url"
                        dense
                    ></v-text-field>
                  </v-flex>

                  <v-flex xs12 md12 sm12 lg12>
                    <v-textarea
                      label="Description de la vidéo"
                      rows="1"
                      prepend-inner-icon="history_edu"
                      outlined
                      v-model="svData.description"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      dense
                    ></v-textarea>
                  </v-flex>
                </v-layout>
              </v-container>
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
          <!-- <v-layout>
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
            <v-flex md4>
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

            <v-flex md6></v-flex>

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
          </v-layout> -->
          <!-- bande -->

          <br />

          <!-- <v-card :loading="loading" :disabled="isloading">
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th>Avatar</th>
                      <th class="text-left">Titre de la vidéo</th>
                      <th class="text-left">Description de la vidéo</th>
                      <th class="text-left">Adresse Url</th>
                      <th>Mise à jour</th>

                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>
                        <v-avatar color="red">
                          <span class="white--text text-h5">
                            {{ item.titre | subStr }}
                          </span>
                        </v-avatar>
                      </td>
                      <td>{{ item.titre | subStrLong2 }}</td>
                      <td>{{ item.description | subStrLong2 }}</td>
                      <td>
                        <v-btn icon :href="item.url" target="_blank">
                          Voir la vidéo...
                        </v-btn>
                      </td>

                      <td>
                        {{ item.created_at | formatDate }}
                        {{ item.created_at | formatHour }}
                      </td>

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
          </v-card> -->

          <!-- les composants -->

          <!-- fin des composants -->
        </v-flex>
      </v-layout>
    </v-flex>
  </v-layout>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  components: {},
  data() {
    return {
      header: "crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      style: {
        height: "0px",
      },
      svData: {
        id: "",
        ceo: "",
        titre: "",
        description: "",
        url: "",
      },
      fetchData: null,
      titreModal: "",
      image: "",
    };
  },

  computed: {
    ...mapGetters(["basicList", "isloading"]),
  },
  methods: {
    ...mapActions(["getBasic"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Paramètrage vidéo ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de vidéo";
        this.style.height = "0px";
      } else {
        this.titleComponent = "Paramètrage vidéo ";
        this.style.height = "0px";
      }
    },

    searchMember: _.debounce(function () {
      this.onPageChange();
    }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_video_entreprise/${this.svData.ceo}?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_video_entreprise`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();

            this.$emit("initialisateur");

            this.dialog = false;


          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_video_entreprise/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.id = item.id;
            this.titleComponent = "modification de la vidéo ";
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_video_entreprise/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
            this.$emit("initialisateur");
          }
        );
      });
    },


    
  },
  created() {
    this.onPageChange();
    this.testTitle();
  },
};
</script>

<style scoped>
.mb-2 {
  margin-top: 10px;
}
</style>