<template>
    <v-layout>
        <!-- <v-flex md2></v-flex> -->
        <v-flex md12>
            <v-flex md12>
                <!--  -->
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="600px" scrollable transition="dialog-bottom-transition">
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
                                </v-tooltip></v-card-title>
                            <v-card-text>

                                <v-container>
                                    <v-layout row wrap>

                                        <v-flex xs12 sm12 md6 lg6>
                                            <div class="mr-1">
                                                <v-autocomplete label="Selectionnez le Mois"
                                                    prepend-inner-icon="mdi-map"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="moisList"
                                                    item-text="name_mois" item-value="id" dense outlined
                                                    v-model="svData.mois_id" chips clearable>
                                                </v-autocomplete>
                                            </div>
                                        </v-flex>
                                        <v-flex xs12 sm12 md6 lg6>
                                            <div class="mr-1">
                                                <v-autocomplete label="Selectionnez l'année"
                                                    prepend-inner-icon="mdi-map"
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="anneeList"
                                                    item-text="name_annee" item-value="id" dense outlined
                                                    v-model="svData.annee_id" chips clearable>
                                                </v-autocomplete>
                                            </div>
                                        </v-flex>


                                        <v-flex xs12 md12 sm6 lg6>
                                            <div class="mr-1">
                                                <v-text-field type="time" label="Heure de Debut" prepend-inner-icon="event" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heure_debut">
                                                </v-text-field>
                                            </div>
                                        </v-flex>
                                        <v-flex xs12 md12 sm6 lg6>
                                            <div class="mr-1">
                                                <v-text-field type="time" label="Heure de Fin" prepend-inner-icon="event" dense
                                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heure_fin">
                                                </v-text-field>                                               
                                            </div>
                                        </v-flex>


                                        <v-flex xs12 md12 sm12 lg12>
                                            <div class="mr-1">
                                                <v-textarea label="Activité exercée" prepend-inner-icon="extension" dense
                                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                                    v-model="svData.activite">
                                                </v-textarea>
                                            </div>
                                        </v-flex>

                                        <v-flex xs12 sm12 md12 lg12>
                                            <div class="mr-1">
                                                <v-select label="Perdième" :items="[
                                                    { designation: 'OUI' },
                                                    { designation: 'NON' }
                                                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']"
                                                    outlined dense item-text="designation" item-value="designation"
                                                    v-model="svData.perdieme">
                                                </v-select>
                                            </div>
                                        </v-flex>

                                    </v-layout>
                                </v-container>

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
                        <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded
                            hide-details v-model="query" @keyup="onPageChange" clearable></v-text-field>
                    </v-flex>

                    <!-- <v-flex md4></v-flex> -->

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
                                        <th class="text-left">Agent</th>
                                        <th class="text-left">Date</th>
                                        <th class="text-left">JourPresté</th>
                                        <th class="text-left">Perdième</th>
                                        <th class="text-left">Activité</th>
                                        <th class="text-left">HeureDebut</th>
                                        <th class="text-left">HeureFin</th>
                                        <th class="text-left">TempPresté</th>
                                        <th class="text-left">ChefProjet</th>
                                        <th class="text-left">Coordo</th>
                                        <th class="text-left">RH</th>
                                        <th class="text-left">Author</th>
                                        <th class="text-left">Mise à jour</th>
                                        <th class="text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in fetchData" :key="item.id">
                                        <td>{{ item.noms_agent }}</td>
                                        <td>{{ item.date_tache }}</td>
                                        <td>{{ item.jour_preste }}</td>
                                        <td>{{ item.perdieme }}</td>
                                        <td>{{ item.activite }}</td>
                                        <td>{{ item.heure_debut }}</td>
                                        <td>{{ item.heure_fin }}</td>
                                        <td>{{ item.nbr_heure }}</td>
                                        <td>
                                            <v-btn elevation="2" x-small class="white--text"
                                                :color="item.ateste_projet == 'NON' ? '#F13D17' : item.ateste_projet == 'OUI' ? '#3DA60C' : 'error'"
                                                depressed>
                                                {{ item.ateste_projet == 'NON' ? 'Attente' : item.ateste_projet == 'OUI'
                                                ? 'Validé' : 'error' }}
                                            </v-btn>
                                        </td>
                                        <td>
                                            <v-btn elevation="2" x-small class="white--text"
                                                :color="item.ateste_coordo == 'NON' ? '#F13D17' : item.ateste_coordo == 'OUI' ? '#3DA60C' : 'error'"
                                                depressed>
                                                {{ item.ateste_coordo == 'NON' ? 'Attente' : item.ateste_coordo ==
                                                'OUI' ? 'Validé' : 'error' }}
                                            </v-btn>
                                        </td>
                                        <td>
                                            <v-btn elevation="2" x-small class="white--text"
                                                :color="item.ateste_rh == 'NON' ? '#F13D17' : item.ateste_rh == 'OUI' ? '#3DA60C' : 'error'"
                                                depressed>
                                                {{ item.ateste_rh == 'NON' ? 'Attente' : item.ateste_rh == 'OUI' ?
                                                'Validé' : 'error' }}
                                            </v-btn>
                                        </td>
                                        <td>{{ item.author }}</td>
                                        <td>
                                            {{ item.created_at | formatDate }}
                                            {{ item.created_at | formatHour }}
                                        </td>

                                        <td>

                                            <v-menu bottom rounded offset-y transition="scale-transition">
                                                <template v-slot:activator="{ on }">
                                                <v-btn icon v-on="on" small fab depressed text>
                                                    <v-icon>more_vert</v-icon>
                                                </v-btn>
                                                </template>

                                                <v-list dense width="">

                                                <v-list-item link @click="editData(item.id)">
                                                    <v-list-item-icon>
                                                    <v-icon color="blue">edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px">Modifier
                                                    </v-list-item-title>
                                                </v-list-item>

                                                <v-list-item link @click="attester_Projet(item.id)">
                                                    <v-list-item-icon>
                                                    <v-icon color="blue">edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px">Attester Chef de Projet
                                                    </v-list-item-title>
                                                </v-list-item>

                                                <v-list-item link @click="attester_Coordo(item.id)">
                                                    <v-list-item-icon>
                                                    <v-icon color="blue">edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px">Attester Coordonateur
                                                    </v-list-item-title>
                                                </v-list-item>

                                                <v-list-item link @click="attester_RH(item.id)">
                                                    <v-list-item-icon>
                                                    <v-icon color="blue">edit</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-title style="margin-left: -20px">Attester RH
                                                    </v-list-item-title>
                                                </v-list-item>

                                                <v-list-item link @click="deleteData(item.id)">
                                                    <v-list-item-icon>
                                                    <v-icon color="red">delete</v-icon>
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
                            @input="onPageChange" :total-visible="7"></v-pagination>
                    </v-card-text>
                </v-card>
                <!-- component -->
                <!-- fin component -->
            </v-flex>
        </v-flex>
        <!-- <v-flex md2></v-flex> -->
    </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    components: {},
    data() {
        return {
            title: "Categorie component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            //'id','affectation_id','user_id','annee_id','mois_id','date_tache',
            // 'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            // 'ateste_projet','ateste_coordo','ateste_rh','author'
            svData: {
                id: "",
                user_id: 0,
                annee_id: 0,
                mois_id: 0,
                //date_tache:'',
                //jour_preste:0,
                perdieme: '',
                activite: '',
                heure_debut: null,
                heure_fin: null,
                //temp_preste:0,
                //   ateste_agent:'',
                //   ateste_projet:'',
                //   ateste_coordo:'',
                //   ateste_rh:'',
                // time: null,
                modal1: false,
                modal2: false,
                author: ""
            },
            fetchData: null,
            titreModal: "",
            anneeList: [],
            moisList: [],
        };
    },
    computed: {
        ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Data";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification des donnees ";
            } else {
                this.titleComponent = "Ajout TimeSheet";
            }
        },
        fetchListAnnee() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_annee2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.anneeList = donnees;
                }
            );
        },
        fetchListMois() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_mois`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.moisList = donnees;
                }
            );
        }
        ,
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_all_jour_perso_timesheet?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);
                if (this.edit) {
                    this.svData.user_id = this.userData.id;
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/update_perso_timesheet/${this.svData.id}`,
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
                    this.svData.user_id = this.userData.id;
                    this.svData.author = this.userData.name;
                    this.insertOrUpdate(
                        `${this.apiBaseURL}/insert_perso_timesheet`,
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_timesheet/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.titleComponent = "modification de " + item.name_institution;
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_perso_timesheet/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },
        attester_Projet(code) {
            this.isLoading(true);
            this.svData.author = this.userData.name;
            this.svData.id = code;
            this.insertOrUpdate(
                `${this.apiBaseURL}/update_perso_chef_projet/${this.svData.id}`,
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
        },
        attester_Coordo(code) {
            this.isLoading(true);
            this.svData.author = this.userData.name;
            this.svData.id = code;
            this.insertOrUpdate(
                `${this.apiBaseURL}/update_perso_coordo_projet/${this.svData.id}`,
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
        },
        attester_RH(code) {
            this.isLoading(true);
            this.svData.author = this.userData.name;
            this.svData.id = code;
            this.insertOrUpdate(
                `${this.apiBaseURL}/update_perso_rh_projet/${this.svData.id}`,
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
        },


    },
    created() {
        this.testTitle();
        this.onPageChange();
        this.fetchListAnnee();
        this.fetchListMois();
    },
};
</script>