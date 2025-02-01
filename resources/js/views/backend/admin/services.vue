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
              <v-container>
                <v-layout row wrap>
                  <v-flex xs12 md12 sm12 lg12>
                    <v-text-field
                      label="Le titre"
                      prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.titre"
                    ></v-text-field>
                  </v-flex>

                  <v-flex xs12 md12 sm12 lg12>
                    <v-text-field
                      label="Icone"
                      prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined
                      v-model="svData.icone"
                    ></v-text-field>
                  </v-flex>

                  <v-flex xs12 md12 sm12 lg12>
                    <div class="mr-1">
                      <v-textarea
                        label="Description"
                        rows="1"
                        prepend-inner-icon="history_edu"
                        outlined
                        v-model="svData.description"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                      ></v-textarea>
                    </div>
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
          </v-layout>
          <!-- bande -->

          <br />
          <v-card :loading="loading" :disabled="isloading">
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Titre</th>
                      <th class="text-left">Description</th>
                      <th class="text-left">Icone</th>
                      <th class="text-left">Mise à jour</th>

                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.titre | subStrLong2 }}</td>
                      <td>{{ item.description | subStrLong2 }}</td>
                      <td>
                        <v-icon>{{ item.icone }}</v-icon>
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
          </v-card>
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
      svData: {
        id: "",
        titre: "",
        description: "",
        icone: "",
      },
      fetchData: null,
      titreModal: "",
    };
  },

  computed: {
    ...mapGetters(["basicList", "isloading"]),
  },
  methods: {
    ...mapActions(["getBasic"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Paramètrage basic ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de service ";
      } else {
        this.titleComponent = "Paramètrage basic ";
      }
    },

    searchMember: _.debounce(function () {
      this.onPageChange();
    }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_service?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_service`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.getBasic();
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_service/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.id = item.id;
            this.titleComponent = "modification de paramètrage basic ";
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_service/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },

    editTitleModal(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_service/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.titleComponent = "modification de service";
          });
        }
      );
    },
  },
  created() {
    this.onPageChange();
    this.testTitle();
    this.onPageChange();
  },
};
</script>