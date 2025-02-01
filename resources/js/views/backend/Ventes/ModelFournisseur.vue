<template> 
    <v-row justify="center">
        <ModelCategorieFournisseur ref="ModelCategorieFournisseur" />
      <v-dialog v-model="etatModal" persistent max-width="1500px">
        <v-card>
          <!-- container -->
  
          <v-card-title class="primary">
            {{ titleComponentss }} <v-spacer></v-spacer>
            <v-btn depressed text small fab @click="etatModal = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <!-- layout -->
  
            <div>
                <v-layout>         
                    <v-flex md12>
                    <v-flex md12>
                        <!-- modal -->
                        <v-dialog v-model="dialog" max-width="400px" scrollable  transition="dialog-bottom-transition">
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
                                <div class="mr-1">
                                    <v-text-field label="Nom complèt" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.noms"></v-text-field>
                                </div>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-text-field label="Adresse complète" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.adresse"></v-text-field>
                                </div>
                                </v-flex>

                                <v-flex xs10 sm10 md10 lg10>
                                <div class="mr-1">
                                    <v-autocomplete label="Selectionnez la Categorie" prepend-inner-icon="home"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.fssList" item-text="nom_categoriefss"
                                    item-value="id" dense outlined v-model="svData.refCategorieFss" chips clearable>
                                    </v-autocomplete>
                                </div>
                                </v-flex>
                                <v-flex xs1 sm1 md1 lg1>
                                <div class="mr-1">
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="get_CategorieFss" color="primary" :loading="loading" dark x-small fab depressed>
                                        <v-icon dark>refresh</v-icon>
                                        </v-btn>
                                    </span>
                                    </template>
                                    <span>Recharger la liste</span>
                                </v-tooltip>
                                </div>
                                </v-flex>
                                <v-flex xs1 sm1 md1 lg1>
                                <div class="mr-1">
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="
                                        showCategorieFournisseur()
                                        " fab x-small color="primary" dark>
                                        <v-icon>add</v-icon>
                                        </v-btn>
                                    </span>
                                    </template>
                                    <span>Ajouter une categorie</span>
                                </v-tooltip>
                                </div>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                    <v-text-field label="Téléphone" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.contact"></v-text-field>
                                </div>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                <div class="mr-1">
                                </div>
                                </v-flex>

                                </v-layout>
                            
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                                <v-btn
                                color="  blue"
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
                            @keyup="onPageChange"
                            clearable
                            ></v-text-field>
                        </v-flex>
                
                        <v-flex md4></v-flex>
                
                        <v-flex md1>
                            <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                <v-btn @click="showModal" fab color="  blue" dark>
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
                                    <th class="text-left">Nom Complet</th>                      
                                    <th class="text-left">Téléphone</th>
                                    <th class="text-left">E-mail</th>
                                    <th class="text-left">Adresse</th>
                                    <th class="text-left">Categorie</th>
                                    <th class="text-left">Mise à jour</th>
                                    <th class="text-left">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                    <td>{{ item.noms }}</td>                      
                                    <td>{{ item.contact }}</td>
                                    <td>{{ item.mail }}</td>
                                    <td>{{ item.adresse }}</td>
                                    <td>{{ item.nom_categoriefss }}</td>
                                    <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                    </td>
                
                                    <td>
                                    <v-tooltip top    color="black">
                                        <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="editData(item.id)" fab small
                                            ><v-icon color="  blue">edit</v-icon></v-btn
                                            >
                                        </span>
                                        </template>
                                        <span>Modifier</span>
                                    </v-tooltip>
                
                                    <!-- <v-tooltip top   color="black">
                                        <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="clearP(item.id)" fab small
                                            ><v-icon color="  red">delete</v-icon></v-btn
                                            >
                                        </span>
                                        </template>
                                        <span>Supprimer</span>
                                    </v-tooltip> -->
                                    </td>
                                </tr>
                                </tbody>
                            </template>
                            </v-simple-table>
                            <hr />
                
                            <v-pagination
                            color="  blue"
                            v-model="pagination.current"
                            :length="pagination.total"
                            @input="onPageChange"
                            :total-visible="7"
                            ></v-pagination>
                        </v-card-text>
                        </v-card>
                        <!-- component -->
                        <!-- fin component -->
                    </v-flex>
                    </v-flex>
                    <v-flex md2></v-flex>
                </v-layout>
            </div>
          
  
            <!-- fin -->
          </v-card-text>
  
          <!-- container -->
        </v-card>
      </v-dialog>
    </v-row>



  </template>
  <script>
    //id','noms','contact','mail','adresse','author'
  import { mapGetters, mapActions } from "vuex";
  import ModelCategorieFournisseur from "./ModelCategorieFournisseur.vue";

  export default {
    components: {
        ModelCategorieFournisseur
    },
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
        etatModal: false,
        titleComponentss: '',

        svData: {
          id: "",
          noms: "",
          contact: "",
          mail: "",
          adresse: "",
          author: "",
          refCategorieFss :0
        },
        fetchData: null,
        titreModal: "",
        fssList: [],
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''
      };
    },
    computed: {
      ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
      ...mapActions(["getRole"]),
  
      showModal() {
        this.dialog = true;
        this.titleComponent = "Ajouter Fournisseur ";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "Modification de " + item.noms;
        } else {
          this.titleComponent = "Ajout Fournisseur ";
        }
      }
      ,
  
    //   searchMember: _.debounce(function () {
    //     this.onPageChange();
    //   }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_fournisseur?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);

          this.svData.author=this.userData.name;
          this.svData.mail = 'exemple@gmail.com'
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_fournisseur`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_fournisseur/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.noms;
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
    showCategorieFournisseur() {
      this.$refs.ModelCategorieFournisseur.$data.etatModal = true;
      this.$refs.ModelCategorieFournisseur.testTitle();
      this.$refs.ModelCategorieFournisseur.onPageChange();
      this.$refs.ModelCategorieFournisseur.fetchListCompte();
      this.get_CategorieFss();

      this.$refs.ModelCategorieFournisseur.$data.titleComponents =
        "Une nouvelle Categorie Fournisseur";

    },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_fournisseur/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },  
      get_CategorieFss() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_categoriefss_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.fssList = donnees;
  
          }
        );
      } ,
  
     
    },
    created() {
       
      this.testTitle();
      this.onPageChange();
      this.get_CategorieFss();
    },
  };
  </script>