<template>
    <v-layout row wrap>
      <v-flex md1></v-flex>
      <v-flex md12>
        <v-flex md12>
          <!-- modal -->
          <v-dialog v-model="dialog" max-width="600px" scrollable  transition="dialog-bottom-transition">
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
                <v-card-text>
                  <v-container grid-list-xs>

                    <v-layout row wrap>
                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-text-field
                                    label="Nom "
                                    prepend-inner-icon="person"
                                    :rules="[(v) => !!v || 'Ce champ est requis']"
                                    outlined
                                    v-model="svData.name"
                                ></v-text-field>
                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-text-field
                                    label="Adresse mail "
                                    prepend-inner-icon="mail"
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

                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-text-field
                                    label="N° de Téléphone "
                                    prepend-inner-icon="call"
                                    :rules="[(v) => !!v || 'Ce champ est requis']"
                                    outlined
                                    v-model="svData.telephone"
                                ></v-text-field>
                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                                <v-text-field
                                    label="Sujet "
                                    prepend-inner-icon="drafts"
                                    :rules="[(v) => !!v || 'Ce champ est requis']"
                                    outlined
                                    v-model="svData.subject"
                                ></v-text-field>
                            </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-textarea
                                    label="Message"
                                    rows="1"
                                    prepend-inner-icon="inbox"
                                    outlined
                                    v-model="svData.message"
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
                  <v-btn
                    color="primary"
                    dark
                    :loading="loading"
                    @click="validate"
                  >
                    {{ edit ? "Modifier" : "Ajouter" }}
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <br /><br />
          <!-- fin modal -->
  
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
                      <th class="text-left">Nom</th>
                      <th class="text-left">Email</th>
                      <th class="text-left">Téléphone</th>
                      <th class="text-left">Sujet</th>
                      <th class="text-left">Mise à jour</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.name }}</td>
                      <td>{{ item.email }}</td>
                      <td>{{ item.telephone | subStrLong2 }}</td>
                      <td>{{ item.subject | subStrLong2 }}</td>
                      
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
                :total-visible="7"
                @input="onPageChange"
              ></v-pagination>
            </v-card-text>
          </v-card>
          <!-- component -->
          <!-- fin component -->
        </v-flex>
      </v-flex>
      <v-flex md1></v-flex>
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    components: {},
    data() {
      return {
        title: "Catégorie component",
        header: "Catégorie operation",
        titleComponent: "",
        query: "",
        dialog: false,
        loading: false,
        disabled: false,
        edit: false,
        svData: {
          id: "",
          name: "",
          email: "",
          telephone: "",
          subject: "",
          message: "",
        },
        fetchData: null,
        titreModal: "",
      };
    },
    computed: {
      ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
      ...mapActions(["getRole"]),
  
      showModal() {
        this.dialog = true;
        this.titleComponent = "Ajout message ";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification de " + item.name;
        } else {
          this.titleComponent = "Ajout un message ";
        }
      },
  
      searchMember: _.debounce(function () {
        this.onPageChange();
      }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_contact_onfo?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_contact_onfo`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.getRole();
              this.onPageChange();
  
              this.dialog = false;
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        }
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_contact_onfo/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.nom;
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_contact_onfo/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
  
      
    },
    created() {
      this.getRole();
      this.testTitle();
      this.onPageChange();
    },
  };
  </script>