<template>
    <v-layout wrap row>
        
        <v-flex md12>
            <v-flex md12>
                <!-- modal  -->
                <!-- <detailLotModal v-on:chargement="rechargement" ref="detailLotModal" /> -->
                <!-- fin modal -->
                <!-- modal -->
               <br><br>
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
                    <v-flex md7>

                        <v-row v-show="showDate">
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-date-picker
                                v-model="dates"
                                range  color="  blue"
                            ></v-date-picker>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-text-field
                                v-model="dateRangeText"
                                label="Date range"
                                prepend-icon="mdi-calendar"
                                readonly
                            ></v-text-field>
                          
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showContratAgentByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DE TOUS CONTRATS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFinContratAgentByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES CONTRATS FINIS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showCongeEncoursAgentByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES CONGES ENCOURS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showStagiaireByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES STAGIARES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPresenceAgentByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES PRESENCES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Projet(Administration)" prepend-inner-icon="mdi-map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="projetList"
                                            item-text="description_projet" item-value="id" outlined v-model="svData.projet_id" dense>
                                        </v-autocomplete>
                                    </div>
                            </v-flex>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showContratProjetByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES CONTRATS/PROJET
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-select label="Sexe" :items="[
                                            { designation: 'Homme' },
                                            { designation: 'Femme' }
                                        ]" prepend-inner-icon="extension"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.sexe_agent"></v-select>
                                    </div>
                            </v-flex>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showContratSexeByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES CONTRATS/SEXE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" dense
                                item-text="name_serv_perso" item-value="id" outlined v-model="svData.refServicePerso">
                            </v-autocomplete>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPresenceAgentServiceByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES PRESENCES/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-autocomplete label="Selectionnez le Type de Contrat" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="contratList"
                                item-text="nom_contrat" item-value="id" dense outlined
                                v-model="svData.refTypeContrat" chips clearable>
                              </v-autocomplete>
                            <!-- <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              
                            </div>
                          </v-flex> -->
                          <!-- <br> -->
                          <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showContratTypeContratAgentByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES CONTRATS/TYPE CONTRAT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-autocomplete label="Selectionnez le Poste" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="postList"
                                item-text="nom_poste" item-value="id" dense outlined
                                v-model="svData.refPoste" chips clearable>
                              </v-autocomplete>
                          <!-- <br> -->
                          <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showContratPosteAgentByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES CONTRATS/POSTE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                          <br>
                          <v-autocomplete label="Selectionnez le lieu d'Affectation" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="lieuList"
                                item-text="nom_lieu" item-value="id" dense outlined
                                v-model="svData.refLieuAffectation" chips clearable>
                              </v-autocomplete>
                          <!-- <br> -->
                          <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showContratLieuAgentByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES CONTRATS/LIEU AFFECTATION
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showPresenceAgentLieuByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES PRESENCES/LIEU AFFECT.
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                          <br>
                          <v-autocomplete label="Selectionnez le Mutuelle de Santé" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="mutuelleList"
                                item-text="nom_mutuelle" item-value="id" dense outlined
                                v-model="svData.refMutuelle" chips clearable>
                              </v-autocomplete>
                          <!-- <br> -->
                          <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showContratMutuelleAgentByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES CONTRATS/MUTUELLE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                          <br>
                          <v-autocomplete label="Selectionnez l'Institution" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="institutionList"
                                  item-text="name_institution" item-value="id" dense outlined v-model="svData.institution_id"
                                  chips clearable>
                                </v-autocomplete>
                            <!-- <br> -->
                          <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showStagiaireInstitutionByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES STAGIARES/INSTITUTION
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <v-autocomplete label="Selectionnez le Type de Stage" prepend-inner-icon="mdi-map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="typestageList"
                                  item-text="name_typestage" item-value="id" dense outlined v-model="svData.typestage_id"
                                  chips clearable>
                                </v-autocomplete>
                            <!-- <br> -->
                          <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showStagiaireTypeStageByDate" block color="  blue" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES STAGIARES/TYPE STAGE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>


                            </v-col>
                        </v-row>
                      
                    </v-flex>
                   
               </v-layout>
                <!-- bande -->

                
            </v-flex>
        </v-flex>
        
    </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
// import detailLotModal from './detailLotModal.vue'
export default {
    components: {
        // detailLotModal,
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
            svData: {
                id: "",                
                refProduit: "", 
                refTypeContrat:0,
                refPoste:0,
                refLieuAffectation:0,
                refMutuelle:0,
                refServicePerso:0,
                conge:'',
                institution_id:0,
                typestage_id:0,
                organisationAbonne:"",
                refMois: 0,
                refAnne: 0,
                refRubrique: 0,
                projet_id:0,
                sexe_agent:''                
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            typecontratList: [],

            lieuList: [],
            serviceList: [],
            postList: [],
            mutuelleList: [],
            contratList: [],
            institutionList: [],
            typestageList: [],
            projetList: [],

            produitList: [],
            rubriqueList: [],
            organisationList: [],
            anneeList: [],
            moisList: [],
            filterValue:'',
            dates:[],
            showDate:false,
        };
    },
    computed: {
        
        dateRangeText () {
            return this.dates.join(' ~ ')
        },
    },
    methods: {
        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Tarification ";
            this.edit = false;
            this.resetObj(this.svData);
            
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de Tarification ";
            } else {
                this.titleComponent = "Ajout Tarification ";
            }
        },        
        onPageChange() {           
           
        },
        fetchListServices() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_service_personnel2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serviceList = donnees;
                    //serviceList
                }
            );
        },
        showContratAgentByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_contrat_date?date1=` + date1+"&date2="+date2);             
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showPresenceAgentByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_presence_date?date1=` + date1+"&date2="+date2);             
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showPresenceAgentServiceByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refServicePerso!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_presence_service_date?date1=` + date1+"&date2="+date2+"&refServicePerso="+this.svData.refServicePerso);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showContratProjetByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.projet_id!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_contrat_date_projet?date1=` + date1+"&date2="+date2+"&projet_id="+this.svData.projet_id);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            } 
        },
        showContratSexeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.sexe_agent!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_contrat_date_sexe?date1=` + date1+"&date2="+date2+"&sexe_agent="+this.svData.sexe_agent);
                }
                else
                {
                    this.showError("Veillez selectionner le sexe svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showPresenceAgentLieuByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refLieuAffectation!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_presence_lieu_date?date1=` + date1+"&date2="+date2+"&refLieuAffectation="+this.svData.refLieuAffectation);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFinContratAgentByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_fincontrat_date?date1=` + date1+"&date2="+date2);             
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showContratTypeContratAgentByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refTypeContrat!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_contrat_date_typecontrat?date1=` + date1+"&date2="+date2+"&refTypeContrat="+this.svData.refTypeContrat);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showContratPosteAgentByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refPoste!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_contrat_date_poste?date1=` + date1+"&date2="+date2+"&refPoste="+this.svData.refPoste);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showContratLieuAgentByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refLieuAffectation!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_contrat_date_LieuAffectation?date1=` + date1+"&date2="+date2+"&refLieuAffectation="+this.svData.refLieuAffectation);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showContratMutuelleAgentByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refMutuelle!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_contrat_date_mutuelle?date1=` + date1+"&date2="+date2+"&refMutuelle="+this.svData.refMutuelle);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showContratCongeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.conge!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_contrat_date_conge?date1=` + date1+"&date2="+date2+"&conge="+this.svData.conge);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showCongeEncoursAgentByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_conge_encours_date?date1=` + date1+"&date2="+date2);             
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showStagiaireByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_rapport_stagiaires_date?date1=` + date1+"&date2="+date2);             
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showStagiaireInstitutionByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.institution_id!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_stagiaires_date_institution?date1=` + date1+"&date2="+date2+"&institution_id="+this.svData.institution_id);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showStagiaireTypeStageByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.typestage_id!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_stagiaires_date_typestage?date1=` + date1+"&date2="+date2+"&typestage_id="+this.svData.typestage_id);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },       

        rechargement()
        {
            this.onPageChange();
            
        },
    fetchListMutuelle() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_mutuelle_pers`).then(
        ({ data }) => {
          var donnees = data.data;
          this.mutuelleList = donnees;
        }
      );
    },
    fetchListPoste() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_poste_pers`).then(
        ({ data }) => {
          var donnees = data.data;
          this.postList = donnees;
        }
      );
    },
    fetchListContrat() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_typecontrat_pers`).then(
        ({ data }) => {
          var donnees = data.data;
          this.contratList = donnees;
        }
      );
    },
    fetchListLieuAffectation() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_lieuaffectation_pers`).then(
        ({ data }) => {
          var donnees = data.data;
          this.lieuList = donnees;
        }
      );
    },
      fetchListInstitution() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_institution_stage2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.institutionList = donnees;
  
          }
        );
  
      },
      fetchListTypeStage() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_type_stage2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.typestageList = donnees;  
          }
        );
  
      },
        fetchListProjet() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_perso_projets2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.projetList = donnees;
                }
            );
        },

       


    },
    created() { 
        this.fetchListMutuelle();
        this.fetchListPoste();
        this.fetchListLieuAffectation();
        this.fetchListContrat();
        this.fetchListInstitution();
        this.fetchListTypeStage(); 
        this.fetchListServices();
        this.fetchListProjet();
        this.showDate=true;
    },
};
</script>