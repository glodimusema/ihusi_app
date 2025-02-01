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
              <v-layout row wrap>
               
                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <!-- <v-textarea
                      label="A propos de nous"
                      rows="1"
                      prepend-inner-icon="import_contacts"
                      outlined
                      v-model="svData.apropos"
                    ></v-textarea> -->
                    <label>A propos de nous</label>
                    <ckeditor
                      label="A propos de nous"
                      :editor="editor"
                      v-html="svData.apropos"
                      v-model="svData.apropos"
                      :config="editorConfig"
                    ></ckeditor>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <!-- <v-textarea
                      label="Ce que nous faisons"
                      rows="1"
                      prepend-inner-icon="history_edu"
                      outlined
                      v-model="svData.travail"
                    ></v-textarea> -->
                    <label>Ce que nous faisons</label>
                    <ckeditor
                      label="Ce que nous faisons"
                      :editor="editor"
                      v-html="svData.travail"
                      v-model="svData.travail"
                      :config="editorConfig"
                    ></ckeditor>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <!-- <v-textarea
                      label="Nous faire un don"
                      rows="1"
                      prepend-inner-icon="pending_actions"
                      outlined
                      v-model="svData.don"
                    ></v-textarea> -->
                    <label>Nous faire un don</label>
                    <ckeditor
                      label="Nous faire un don"
                      :editor="editor"
                      v-html="svData.don"
                      v-model="svData.don"
                      :config="editorConfig"
                    ></ckeditor>
                  </div>
                </v-flex>

                <v-flex xs12 md12 sm12 lg12>
                  <div class="mr-1">
                    <!-- <v-textarea
                      label="Structure de gestion"
                      rows="1"
                      prepend-inner-icon="extension"
                      outlined
                      v-model="svData.structure"
                    ></v-textarea> -->
                    <label>Structure de gestion</label>
                    <ckeditor
                      label="Structure de gestion"
                      :editor="editor"
                      v-html="svData.structure"
                      v-model="svData.structure"
                      :config="editorConfig"
                    ></ckeditor>
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
                      <th class="text-left">A propos</th>
                      <th class="text-left">Ce que nous faisons</th>
                      <th class="text-left">Faire un Don</th>
                      <th class="text-left">Structure</th>

                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.apropos | subStrLong }}</td>
                      <td>{{ item.travail | subStrLong }}</td>
                      <td>{{ item.don | subStrLong }}</td>
                      <td>{{ item.structure | subStrLong }}</td>

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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  components: {},
  data() {
    return {
      header: "basic operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      svData: {
        id: "",
        apropos: "",
        travail: "",
        don: "",
        structure: "",
      },
      fetchData: null,
      titreModal: "",
      editor: ClassicEditor,
      editorConfig: {
        // The configuration of the editor.
        //  toolbar: [ 'bold', 'italic', '|', 'link' ]
      },
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
        this.titleComponent = "modification de Paramètrage basic ";
      } else {
        this.titleComponent = "Paramètrage basic ";
      }
    },

    searchMember: _.debounce(function () {
      this.onPageChange();
    }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_basic?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_basic`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_basic/${id}`).then(
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
        this.delGlobal(`${this.apiBaseURL}/delete_basic/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },

    editTitleModal(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_basic/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.titleComponent = "modification de paramètrage basic ";
          });
        }
      );
    },
  },
  created() {
    this.getBasic();
    this.testTitle();
    this.onPageChange();
  },
};
</script>