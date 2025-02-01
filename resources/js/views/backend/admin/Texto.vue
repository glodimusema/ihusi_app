<template>
    <v-layout>
      <v-flex md1></v-flex>
      <v-flex md10>
        <v-flex md12>
          <!-- modal -->
          <v-dialog v-model="dialog" max-width="500px" scrollable  transition="dialog-bottom-transition">
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

                    <v-layout row wrap>

                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-12">
                                {{svData.phone}}
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Liste des ceo" prepend-inner-icon="person"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="userListAll"
                                    item-text="name" item-value="telephone" outlined clearable v-model="svData.phone"
                                    chips multiple dense>
                                    <template v-slot:item="data">

                                        <template>
                                            <v-list-item-avatar>
                                                <img :src="
                                                    data.item.avatar == null
                                                    ? `${baseURL}/images/avatar.png`
                                                    : `${baseURL}/images/` + data.item.avatar
                                                " alt="alt" />
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title v-html="data.item.name">
                                                </v-list-item-title>
                                                <v-list-item-subtitle v-html="data.item.email">
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </template>
                                    </template>
                                </v-autocomplete>
                            </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-textarea
                                    label="Message"
                                    rows="1"
                                    prepend-inner-icon="history_edu"
                                    outlined
                                    v-model="svData.message"
                                    :rules="[(v) => !!v || 'Ce champ est requis']"
                                ></v-textarea>
                            </div>
                            
                        </v-flex>
                    </v-layout>
                    

                    


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
                        <th class="text-left">Numéro de téléphone</th>
                        <th class="text-left">Message</th>
                        <th class="text-left">Etat de messagerie</th>
                        <th class="text-left">Mise à jour</th>
                        <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.phone }}</td>
                      <td>{{ item.message | subStrLong2 }}</td>
                      <td>
                        <v-badge
                          bordered
                          color="error"
                          icon="visibility"
                          overlap
                        >
                          <v-btn
                            elevation="2"
                            x-small
                            class="white--text"
                            :color="item.etat == 1 ? 'success' : 'error'"
                            depressed
                            @click="operationEtat(item.id, item.phone, item.etat)"
                          >
                            {{ item.etat == 1 ? "Envoyé" : "Non Envoyé" }}
                          </v-btn>
                        </v-badge>
                      </td>
                      <td>
                        {{ item.created_at | formatDate }}
                        {{ item.created_at | formatHour }}
                      </td>
  
                      <td>
                        <!-- <v-tooltip top color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="editData(item.id)" fab small
                                ><v-icon color="primary">edit</v-icon></v-btn
                              >
                            </span>
                          </template>
                          <span>Modifier</span>
                        </v-tooltip> -->
  
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
        title: "Pays component",
        header: "Crud operation",
        titleComponent: "",
        query: "",
        dialog: false,
        loading: false,
        disabled: false,
        edit: false,
        svData: {
          id: "",
          phone:[],
          message: "",
        },
        fetchData: null,
        titreModal: "",
      };
    },
    computed: {
      ...mapGetters(["roleList","userListAll", "isloading"]),
    },
    methods: {
      ...mapActions(["getRole", "getUserAll"]),

      operationEtat(id, phone, etat) {
      if (id != "" && phone != "" && etat != "") {
        // alert("id:"+id+" etat:"+etat);

        this.confirmEtat().then(({ res }) => {
          this.delGlobal(
            `${this.apiBaseURL}/checkEtat_texto/${id}/${phone}/${etat}`
          ).then(({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          });
        });
      } else {
        this.confirmEtat().then(({ res }) => {
          this.delGlobal(
            `${this.apiBaseURL}/checkEtat_texto/${id}/${phone}/${etat}`
          ).then(({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          });
        });
      }
    },
  
      showModal() {
        this.dialog = true;
        this.titleComponent = "Ajout messagerie ";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification de messagerie " + item.nomSecteur;
        } else {
          this.titleComponent = "Ajout messagerie ";
        }
      },
  
      searchMember: _.debounce(function () {
        this.onPageChange();
      }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_texto?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_texto`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.onPageChange();
  
              this.dialog = false;
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        }
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_texto/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.nomSecteur;
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_texto/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
  
     
    },
    created() {
      this.getUserAll();
      this.testTitle();
      this.onPageChange();
    },
  };
  </script>