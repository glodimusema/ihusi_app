<template>
  <v-layout wrap row>

    <v-flex xs12 lg4 md4 sm12>
       <div class="mr-1">
            <v-card>
                <v-card-text>
                   <v-container grid-list-xs>

                        <!-- bande -->
                        <v-layout row wrap>
                            <v-flex md2>
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
                            &nbsp;&nbsp;
                            
                            <v-flex md8>
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

                            <v-flex md1>
                                <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                    <v-btn  @click.stop="showPDGNavigation()" fab color="primary">
                                        <v-icon>person</v-icon>
                                    </v-btn>
                                    </span>
                                </template>
                                <span>Voir la liste des entrepreneurs </span>
                                </v-tooltip>
                            </v-flex>
                            <v-flex md1></v-flex>
                            
                        </v-layout>

                        <v-layout row wrap>
                            <v-flex xs12 md12>
                                <!-- list item -->
                                <v-divider></v-divider>

                                <v-list dense>
                                    <v-subheader>Filtrage par localisation</v-subheader>
                                    <v-list-item-group
                                        v-model="settings"
                                        color="primary"
                                        v-for="(item, index) in ListMenu" :key="index"
                                    >
                                       

                                        <!-- item -->
                                        <v-list-item
                                        v-for="(item2) in item.listePays" :key="item2.idProvince+'-'+item2.nomPays"
                                        @click="getEntrentreprisePays(item2.idPays)"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>check</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item2.nomPays}}</v-list-item-title>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-badge left color="purple">
                                                    <span slot="badge">
                                                        {{item2.nbrEntreprise > 1 ? item2.nbrEntreprise+' Entreprises' : item2.nbrEntreprise+' Entreprise' }} 
                                                    </span> <!--slot can be any component-->
                                                    
                                                </v-badge>
                                            </v-list-item-action>
                                        </v-list-item>
                                        <!-- fin item -->

                                       
                                         <!-- item -->
                                        <v-list-item
                                        v-for="(item3) in item.listeProvince" :key="item3.idProvince+'-'+item3.nomProvince"
                                        @click="getEntrentrepriseProvince(item3.idProvince)"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>check</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item3.nomProvince}}</v-list-item-title>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-badge left color="success">
                                                    <span slot="badge">
                                                        {{item3.nbrEntreprise > 1 ? item3.nbrEntreprise+' Entreprises' : item3.nbrEntreprise+' Entreprise' }} 
                                                    </span> <!--slot can be any component-->
                                                    
                                                </v-badge>
                                            </v-list-item-action>
                                        </v-list-item>
                                        <!-- fin item -->
                                        <v-subheader>Filtrage par secteur</v-subheader>
                                        <!-- item -->
                                        <v-list-item
                                        v-for="(item3) in item.listeSecteur" :key="item3.idsecteur+'-'+item3.nomSecteur"
                                        @click="getEntrepriseSecteur(item3.idsecteur)"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>check</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item3.nomSecteur}}</v-list-item-title>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-badge left color="pink lighten-4">
                                                    <span slot="badge">
                                                        {{item3.nbrEntreprise > 1 ? item3.nbrEntreprise+' Entreprises' : item3.nbrEntreprise+' Entreprise' }} 
                                                    </span> <!--slot can be any component-->
                                                    
                                                </v-badge>
                                            </v-list-item-action>
                                        </v-list-item>
                                        <!-- fin item -->

                                        <v-subheader>Filtrage par Edition</v-subheader>
                                        <!-- item -->
                                        <v-list-item
                                        v-for="(item3) in item.listeEdition" :key="item3.edition+'-'+item3.edition"
                                        @click="getEntrepriseEdition(item3.edition)"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>check</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>Edition {{item3.edition}}</v-list-item-title>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-badge left color="indigo lighten-2">
                                                    <span slot="badge">
                                                        {{item3.nbrEntreprise > 1 ? item3.nbrEntreprise+' Entreprises' : item3.nbrEntreprise+' Entreprise' }} 
                                                    </span> <!--slot can be any component-->
                                                    
                                                </v-badge>
                                            </v-list-item-action>
                                        </v-list-item>
                                        <!-- fin item -->

                                        <!-- fin item -->
                                        <v-subheader>Filtrage par forme juridique</v-subheader>
                                        <!-- item -->
                                        <v-list-item
                                        v-for="(item3) in item.listeFormeJuridique" :key="item3.idforme+'-'+item3.nomForme"
                                        @click="getEntrepriseForme(item3.idforme)"
                                        >
                                            <v-list-item-icon>
                                                <v-icon>check</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-content>
                                                <v-list-item-title>{{item3.nomForme}}</v-list-item-title>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-badge left color="indigo">
                                                    <span slot="badge">
                                                        {{item3.nbrEntreprise > 1 ? item3.nbrEntreprise+' Entreprises' : item3.nbrEntreprise+' Entreprise' }} 
                                                    </span> 
                                                    
                                                </v-badge>
                                            </v-list-item-action>
                                        </v-list-item>
                                        <!-- fin item -->

                                        

                                    </v-list-item-group>
                                </v-list>

                               
                                 <!-- fin list item -->
                                
                            </v-flex>
                        </v-layout>

                        
                        <!-- bande --> 
                    
                   </v-container> 
                </v-card-text>
            </v-card>

       </div>
    </v-flex>

    <v-flex xs12 lg8 md8 sm12>
        <div class="mr-1">

            <!-- debit -->
            <v-card :loading="loading" :disabled="isloading">
                <v-card-text>

                    <v-layout row wrap>
                        <v-flex xs12 md12 lg12 sm12>
                            
                            <v-container grid-list-xs>
                                <!-- item -->
                                <showEntreprise v-bind:datas="fetchData" />
                                <!-- fin -->

                                
                            </v-container>
                        </v-flex>

                        <v-flex xs12 md12 lg12 sm12>

                            <div class="text-center">
                                <v-pagination
                                    color="primary"
                                    v-model="pagination.current"
                                    :length="pagination.total"
                                    :total-visible="7"
                                    @input="
                                    onPageChange
                                    "
                                ></v-pagination>
                            </div>
                            
                        </v-flex>
                    </v-layout>
                   
                   
                </v-card-text>
            </v-card>
            <!-- fin debit -->

        </div>
        
    </v-flex>

    <ListeCeo v-bind:drawer="drawer" />
    
   
   
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import userImage from "../../../../component/userImage.vue";
import showEntreprise from "./showEntreprise.vue";
import ListeCeo from "./ListeCeo.vue";
export default {
  components: {
    userImage,
    showEntreprise,
    ListeCeo,
  },
  data() {
    return {
        title: "Pays component",
        header: "Crud operation",
        titleComponent: "",
        query: "",
        query2: "",
        dialog: false,
        loading: false,
        disabled: false,
        edit: false,
        settings: [],
       

        image:"",
        logo:"",
        style: {
            height: "0px",
        },

        

        drawer: null,
       
      
        fetchData: null,
        titreModal: "",
        fetchData_2:null,
        ListMenu:null,
        etatFiltre:null,

    };
  },
  computed: {
    ...mapGetters([
        "isloading",
        "paysList",
        "provinceList",
        "user2List",
        "formeJuridiqueList",
        "secteurList",
        "ListeEdition",
        "ListeNBREmploye",
    ]),
  },
  methods: {
    ...mapActions([
        "getPays",
        "getProvince",
        "getUser2",
        "getFormejuridique",
        "getSecteurList"
    ]),

    showPDGNavigation()
    {
        this.drawer = !this.drawer;
    },

   

    searchMember: _.debounce(function () {
      this.onPageChange();
    }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entreprise?page=`);
    },

    //fetch ceo
    searchMember2: _.debounce(function () {
      this.onPageChangeCeoEntreprise();
    }, 300),
    onPageChangeCeoEntreprise() {
      this.fetch_data_ceoEntreprise(`${this.apiBaseURL}/fetch_ceo_entreprise?page=`);
    },

    //voir les menus
    showMenuParam(){
        this.disabled = true;
        this.editOrFetch(`${this.apiBaseURL}/fetch_filtre_menu_entreprise`).then(
            ({ data }) => {
                var donnees = data.data;
                this.ListMenu = donnees;
                this.disabled = false;

            }
        );
    },

    
    //pays
    getEntrentreprisePays(idPays){
        this.fetch_data(`${this.apiBaseURL}/getEntreprisePays/${idPays}?page=`);
    },
    //province
    getEntrentrepriseProvince(idProvince){
        this.fetch_data(`${this.apiBaseURL}/getEntreprisePprovince/${idProvince}?page=`);
    },
    //secteur
    getEntrepriseSecteur(idsecteur){
        this.fetch_data(`${this.apiBaseURL}/getEntrepriseSecteur/${idsecteur}?page=`);
    },
    //edition
    getEntrepriseEdition(edition){
        this.fetch_data(`${this.apiBaseURL}/getEntrepriseEdition/${edition}?page=`);
    },
    //formejuridique
    getEntrepriseForme(idforme){
        this.fetch_data(`${this.apiBaseURL}/getEntrepriseForme/${idforme}?page=`);
    },
    
    
    
    

    

    

   



  },
  created() {
    this.onPageChange();
    this.onPageChangeCeoEntreprise();
    this.showMenuParam();
  },
};
</script>
