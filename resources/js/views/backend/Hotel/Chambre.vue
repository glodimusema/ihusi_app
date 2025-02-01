<template>
    <v-layout>
        <v-flex md2></v-flex>
        <v-flex md8>
            <v-flex md12>
                <!-- modal -->
                <v-dialog v-model="dialog" max-width="400px" scrollable transition="dialog-bottom-transition">
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

                                <v-layout row wrap>

                                    <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Classe" prepend-inner-icon="mdi-map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="classeList"
                                            item-text="designation" item-value="id" dense outlined v-model="svData.refClasse"
                                            chips clearable>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="Designation de Chambre" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                    v-model="svData.nom_chambre"></v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="N° Chambre" prepend-inner-icon="extension"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                    v-model="svData.numero_chambre"></v-text-field>
                                    </div>
                                </v-flex>


                                </v-layout> 
                                
                                    
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
                                        <th class="text-left">NomChambre</th>
                                        <th class="text-left">N°Chambre</th>
                                        <th class="text-left">Classe</th>   
                                        <th class="text-left">Prix</th>   
                                        <th class="text-left">Devise</th>                                     
                                        <th class="text-left">Author</th>
                                        <th class="text-left">Mise à jour</th>
                                        <th class="text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in fetchData" :key="item.id">
                                        <td>{{ item.nom_chambre }}</td>
                                        <td>{{ item.numero_chambre }}</td>
                                        <td>{{ item.ClasseChambre }}</td>
                                        <td>{{ item.prix_chambre }}</td>
                                        <td>{{ item.devise }}</td>
                                        <td>{{ item.author }}</td>
                                        <td>
                                            {{ item.created_at | formatDate }}
                                            {{ item.created_at | formatHour }}
                                        </td>

                                        <td>
                                            <v-tooltip  top color="black">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <span v-bind="attrs" v-on="on">
                                                        <v-btn @click="editData(item.id)" fab small><v-icon
                                                                color="  blue">edit</v-icon></v-btn>
                                                    </span>
                                                </template>
                                                <span>Modifier</span>
                                            </v-tooltip>

                                            <!-- <v-tooltip  top color="black">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <span v-bind="attrs" v-on="on">
                                                        <v-btn @click="clearP(item.id)" fab small><v-icon
                                                                color="  red">delete</v-icon></v-btn>
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

                        <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                            @input="onPageChange" :total-visible="7"></v-pagination>
                    </v-card-text>
                </v-card>
                <!-- component -->
                <!-- fin component -->
            </v-flex>
        </v-flex>
        <v-flex md2></v-flex>
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

            //'id','nom_chambre','numero_chambre','refClasse','author'

            svData: {
                id: "",
                nom_chambre: "",
                numero_chambre: 0,
                refClasse: "",
                author: "",
                refUser : 0,
            },
            fetchData: null,
            titreModal: "",
            classeList: []
        };
    },
    computed: {
        ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
        ...mapActions(["getRole"]),

        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Chambre ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de " + item.nom_chambre;
            } else {
                this.titleComponent = "Ajout Catégorie ";
            }
        },
        onPageChange() {
            this.fetch_data(`${this.apiBaseURL}/fetch_hotel_chambre?page=`);
        },

        validate() {
            if (this.$refs.form.validate()) {
                this.isLoading(true);

                this.svData.author = this.userData.name;
                this.svData.refUser = this.userData.id;

                this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_hotel_chambre`,
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
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_hotel_chambre/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;

                    donnees.map((item) => {
                        this.titleComponent = "modification de " + item.nom_chambre;
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                this.delGlobal(`${this.apiBaseURL}/delete_hotel_chambre/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        fetchListCategorie() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_thotel_classe_chambre_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.classeList = donnees;

                }
            );

        },


    },
    created() {

        this.testTitle();
        this.onPageChange();
        this.fetchListCategorie();
    },
};
</script>