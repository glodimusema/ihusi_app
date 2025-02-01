<template>
    <div>


        <v-layout>

            <ActiviteProjet ref="ActiviteProjet" />

            <v-flex md12>
                <v-dialog v-model="dialog" max-width="400px" persistent>
                    <v-card :loading="loading">
                        <v-form ref="form" lazy-validation>
                            <v-card-title>
                                Ajouter Projet <v-spacer></v-spacer>
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="dialog = false" text fab depressed>
                                                <v-icon>close</v-icon>
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Fermer</span>
                                </v-tooltip>
                            </v-card-title>
                            <v-card-text>

                                <v-autocomplete label="Selectionnez le Bailleur" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="partenaireList" dense
                                    item-text="nom_org" item-value="id" outlined v-model="svData.partenaire_id">
                                </v-autocomplete>

                                <v-autocomplete label="Selectionnez le Type Contrat" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="contratList" dense
                                    item-text="nom_contrat" item-value="id" outlined v-model="svData.typecontrat_id">
                                </v-autocomplete>

                                <v-text-field label="Description du Projet" prepend-inner-icon="extension" dense
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                    v-model="svData.description_projet"></v-text-field>

                                <v-text-field label="Chef du Projet" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                    v-model="svData.chef_projet" dense></v-text-field>

                                <v-text-field type="date" label="Date debut" prepend-inner-icon="event" dense
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_debut_projet">
                                </v-text-field>

                                <v-text-field type="number" label="Durée du projet (Jour)" prepend-inner-icon="event" dense
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.duree_projet">
                                </v-text-field>

                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                                <v-btn color="  blue" dark :loading="loading" @click="validate">
                                    {{ edit ? "Modifier" : "Ajouter" }}
                                </v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-dialog>
                <br /><br />
                <v-layout>
                    <v-flex md1>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                        <v-btn :loading="loading" fab @click="fetchDataList">
                                            <v-icon>autorenew</v-icon>
                                            </v-btn>
                                        </span>
                            </template>
                            <span>Initialiser</span>
                        </v-tooltip>
                    </v-flex>
                    <v-flex md12>
                        <v-layout>
                            <v-flex md6>
                                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..."
                                    single-line solo outlined rounded hide-details v-model="query"
                                    @keyup="fetchDataList" clearable></v-text-field>
                            </v-flex>
                            <v-flex md5>


                            </v-flex>
                            <v-flex md1>
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="dialog = true" fab color="  blue" dark>
                                                <v-icon>add</v-icon>
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Ajouter un Projet</span>
                                </v-tooltip>
                            </v-flex>
                        </v-layout>
                        <br />
                        <v-card>
                            <v-card-text>
                                <v-simple-table>
                                    <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th class="text-left">Bailleur</th>
                                                <th class="text-left">TypeContrat</th>
                                                <th class="text-left">Description</th>
                                                <th class="text-left">ChefProjet</th>
                                                <th class="text-left">Datedebut</th>
                                                <th class="text-left">Durée</th>
                                                <th class="text-left">DateFin</th>
                                                <th class="text-left">Observation</th>
                                                <th class="text-left">Author</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in fetchData" :key="item.id">
                                                <td>{{ item.nom_org }}</td>
                                                <td>{{ item.nom_contrat }}</td>
                                                <td>{{ item.description_projet }}</td>
                                                <td>{{ item.chef_projet }}</td>
                                                <td>{{ item.date_debut_projet | formatDate }}</td>
                                                <td>{{ item.duree_projet }}</td>
                                                <td>{{ item.date_fin_projet | formatDate}}</td>
                                                <td>
                                                    <v-btn
                                                        elevation="2"
                                                        x-small
                                                        class="white--text"
                                                        :color="item.dureerestante > 0 ? '#3DA60C' : item.dureerestante <= 0 ? '#F13D17' :'error'"
                                                        depressed                            
                                                        >
                                                        {{ item.dureerestante > 0 ? 'Encours' : item.dureerestante <= 0 ? 'Fin Contrat' :'error' }}
                                                    </v-btn>
                                                </td>
                                                <td>{{ item.author }}</td>
                                                <td>


                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                        <v-list-item link @click="showActiviteProjet(item.id, item.description_projet)">
                                          <v-list-item-icon>
                                            <v-icon color="  blue">description</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Les Taches pour le Projet
                                          </v-list-item-title>
                                        </v-list-item>

                                      <v-list-item link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="  red">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Supprimer
                                        </v-list-item-title>
                                      </v-list-item>

                                    </v-list>


                                  </v-menu>

                                                 


                                                </td>
                                            </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                                <hr />

                                <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                                    @input="fetchDataList"></v-pagination>
                            </v-card-text>
                        </v-card>
                    </v-flex>

                </v-layout>
            </v-flex>

        </v-layout>

    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import ActiviteProjet from "./ActiviteProjet.vue";


export default {
    components:{
        ActiviteProjet
    },
    data() {
        return {
            title: "Liste des Produits",
            dialog: false,
            edit: false,
            loading: false,
            disabled: false,


            //'id','partenaire_id', 'typecontrat_id', 'description_projet', 
            //'chef_projet', 'date_debut_projet','duree_projet,', 'date_fin_projet', 'author'

            svData: {
                id: '',
                partenaire_id: 0,
                typecontrat_id: 0,
                description_projet: '',
                chef_projet: '',
                date_debut_projet: '',
                duree_projet: 0,
                date_fin_projet: '',
                author: ''
            },
            fetchData: [],
            contratList: [],
            partenaireList: [],
            query: "",

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: ''

        }
    },
    created() {
        this.fetchDataList();
        this.fetchListContrat();
        this.fetchListPartenaire();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {

        ...mapActions(["getCategory"]),

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);
                if (this.edit) {
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/update_perso_projtes`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });

                }
                else {
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_perso_projtes`,
                        JSON.stringify(this.svData)
                    )
                        .then(({ data }) => {
                            this.showMsg(data.data);
                            this.isLoading(false);
                            this.edit = false;
                            this.dialog = false;
                            this.resetObj(this.svData);
                            this.fetchDataList();
                        })
                        .catch((err) => {
                            this.svErr(), this.isLoading(false);
                        });
                }

            }
        },

        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_projtes/${id}`).then(
                ({ data }) => {
                    this.titleComponent = "modification des informations";

                    this.getSvData(this.svData, data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },
        deleteData(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_perso_projtes/${id}`).then(
                    ({ data }) => {
                        this.showMsg(data.data);
                        this.fetchDataList();
                    }
                );
            });
        },
        fetchDataList() {
            this.fetch_data(`${this.apiBaseURL}/fetch_all_perso_projtes?page=`);
        },
        fetchListContrat() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_typecontrat_pers`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.contratList = donnees;
                    //partenaireList
                }
            );
        },
        fetchListPartenaire() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_perso_partenaire`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.partenaireList = donnees;
                    //partenaireList
                }
            );
        },
    showActiviteProjet(projet_id, name) {

      if (projet_id != '') {

        this.$refs.ActiviteProjet.$data.etatModal = true;
        this.$refs.ActiviteProjet.$data.projet_id = projet_id;
        this.$refs.ActiviteProjet.$data.svData.projet_id = projet_id;
        this.$refs.ActiviteProjet.fetchDataList();
        this.fetchDataList();

        this.$refs.ActiviteProjet.$data.titleComponent =
          "Les taches pour le projet " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }


    }

    },
    filters: {

    }
}
</script>