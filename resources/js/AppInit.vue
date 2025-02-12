<template>
  <v-app id="inspire">
    <!-- navigation -->
    <v-navigation-drawer v-model="drawer" app>
      <!-- navigation -->
      <Navigation :linkAdmin="linkAdmin" />
      <!-- fin navigation -->
    </v-navigation-drawer>
    <!-- fin navigation -->

    <!-- appbar -->
    <v-app-bar app elevate-on-scroll elevation="3">

      <v-app-bar-nav-icon @click="drawer = !drawer"> </v-app-bar-nav-icon>


      <v-spacer />



      <v-spacer />
      <!-- notification -->
      <v-btn @click="changeTheme" small fab depressed class="mr-2">
        <v-icon>{{ themeIcon }}</v-icon>
      </v-btn>
      <!-- <Notification /> -->
      <!-- fin notification -->

      <!-- navMenu avatar -->
      <NavMenu />
      <!-- fin navMenu avatar -->
      <v-progress-linear v-show="isloading" :indeterminate="isloading" absolute bottom
        color="primary"></v-progress-linear>
    </v-app-bar>
    <!-- fin apbar -->

    <v-main style="background: #f5f5f540">
      <v-container class="py-8 px-6" fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Navigation from "./views/component/navigation.vue";
import Notification from "./views/component/notification.vue";
import NavMenu from "./views/component/navMenu.vue";
export default {
  name: "App",
  components: {
    Navigation,
    Notification,
    NavMenu,
  },
  data() {
    return {
      cards: ["Today", "Yesterday"],
      drawer: true,

      themeIcon: "dark_mode",
      lightBg: "background: rgb(246 248 250)",
      darkBg: "background:rgb(40, 42, 54)",

      linkAdmin: [],
    };
  },
  created() {
    this.showConnected();
    this.testLink();
  },
  computed: {
    ...mapGetters(["userList", "isloading"]),
  },
  methods: {

    ...mapActions(["getUser"]),

    changeTheme() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      !this.$vuetify.theme.dark ? this.lightMode() : this.darkMode();
    },
    lightMode() {
      this.themeIcon = "dark_mode";
      this.$store.state.bgColor = this.lightBg;
    },
    darkMode() {
      this.themeIcon = "light_mode";
      this.$store.state.bgColor = this.darkBg;
    },

    showConnected() {
      var connected = this.userData.email;
      // console.log("user connected:" + connected);
    },
    testLink() {
      if (this.userData.id_role == 1) {
        this.linkAdmin = {
          links: [
            {
              icon: "mdi-microsoft-windows",
              text: "Tableau de bord",
              href: "/admin/dashboard",
            },
            {
              icon: "mdi-chart-pie",
              text: "Tableau de bord(Ese)",
              href: "/admin/statistique_entreprise",
            },
            {
              icon: "chat",
              text: "Chat",
              href: "/admin/chat",
            },
          ],
          links_operation_2: [
            {
              icon: "credit_card",
              text: "Carousel",
              href: "/admin/carousel",
            },
            {
              icon: "credit_card",
              text: "Service",
              href: "/admin/operation_service",
            },
            {
              icon: "store",
              text: "Galérie",
              href: "/admin/operation_galery",
            },
            {
              icon: "store",
              text: "Vidéo",
              href: "/admin/operation_video",
            },
            {
              icon: "store",
              text: "Partenaire",
              href: "/admin/operation_partenaire",
            },

            {
              icon: "store",
              text: "Notre famille",
              href: "/admin/operation_team",
            },

          ],
          links_finance: [
            {
              icon: "groups",
              text: "Classes",
              href: "/admin/ClassesFin",
            },
            {
              icon: "groups",
              text: "Comptes",
              href: "/admin/CompteFin",
            },
            {
              icon: "groups",
              text: "Sous Comptes",
              href: "/admin/SousCompte",
            },
            {
              icon: "groups",
              text: "SSous Comptes",
              href: "/admin/SSousCompte",
            },
            {
              icon: "groups",
              text: "Type Compte",
              href: "/admin/TypeCompte",
            },
            {
              icon: "groups",
              text: "Config. Taux",
              href: "/admin/TTaux",
            },
            {
              icon: "groups",
              text: "Type Position",
              href: "/admin/TypePosition",
            },
            {
              icon: "groups",
              text: "Type Opération",
              href: "/admin/TypeOperation",
            },
            // {
            //   text: "Rubriques",
            //   href: "/admin/Comptes",
            // },
            {
              text: "Caisse&Banque",
              href: "/admin/Banque",
            },
            {
              text: "ModePaie",
              href: "/admin/modepaie",
            },
            {
              icon: "groups",
              text: "Services Treseorerie",
              href: "/admin/Provenance",
            },
            {
              icon: "groups",
              text: "Cat. Rubriques",
              href: "/admin/CategorieRubrique",
            },
            {
              icon: "groups",
              text: "Rubriques Depenses",
              href: "/admin/Rubriques",
            },
            {
              icon: "groups",
              text: "Blocs",
              href: "/admin/Blocs",
            }

          ],
          links_vente: [
                        {//VenteGrandeCategorieProduit
                          icon: "groups",
                          text: "Grande Cat. Produit",
                          href: "/admin/VenteGrandeCategorieProduit",
                        },
                        {//VenteGrandeCategorieProduit
                          icon: "groups",
                          text: "Catégorie Produit",
                          href: "/admin/CategorieProduit",
                        },
                        {//VenteUserService
                          icon: "groups",
                           text: "Config. TVA",
                          href: "/admin/VenteTVA",
                        },
                        {//VenteTables
                          icon: "groups",
                          text: "User-Service",
                          href: "/admin/VenteUserService",
                        },
                        {//VenteTables
                          icon: "groups",
                          text: "Tables",
                          href: "/admin/VenteTables",
                        },
                        {
                          icon: "groups",
                          text: "Catégorie Fournisseur",
                          href: "/admin/CategorieFournisseur",
                        },
                        {
                          icon: "groups",
                          text: "Unité Produit",
                          href: "/admin/VenteUnite",
                        },
                        {//VenteDevise
                          icon: "groups",
                          text: "Devise",
                          href: "/admin/VenteDevise",
                        },
                        {
                          icon: "groups",
                          text: "Services Vente",
                          href: "/admin/VenteServices",
                        },
                        {
                          icon: "groups",
                          text: "Modules",
                          href: "/admin/VenteModules",
                        },
                        {
                          icon: "groups",
                          text: "Les Autorisations",
                          href: "/admin/VenteAutorisation",
                        },
                        {
                          icon: "groups",
                          text: "Emplacements",
                          href: "/admin/Emplacements",
                        },
                        {
                          icon: "groups",
                          text: "Paramètres Code",
                          href: "/admin/ParamSystem",
                        },
                        {
                          icon: "groups",
                          text: "Service Logistique",
                          href: "/admin/SalonProduit",
                        },
                        {
                          icon: "groups",
                          text: "Service Salon",
                          href: "/admin/SalonProduit",
                        },
                        {
                          icon: "groups",
                          text: "CatégorieClient",
                          href: "/admin/CategorieClient",
                        }
          ],
          links_tresorerie: [
            {
              text: "Rubriques Depenses",
              href: "/admin/Comptes",
            },
            {
              text: "Cat.Rubriques EB",
              href: "/admin/CategorieRubrique",
            },
            {
              text: "Rubriques EB",
              href: "/admin/Rubriques",
            },
            {
              text: "Blocs(Finances)",
              href: "/admin/Blocs",
            },
            {
              text: "Les Services(Finances)",
              href: "/admin/Provenance",
            }
          ],
          links_hotel: [
            {
              text: "ClasseChambre",
              href: "/admin/ClasseChambre",
            },
            {
              text: "Chambres",
              href: "/admin/Chambre",
            },
            { //SalonProduit
              text: "Salles",
              href: "/admin/Salle",
            },
            { //SalonProduit
              text: "Services Salon",
              href: "/admin/SalonProduit",
            }
          ],
          links_personne: [
                {
                  text: "Type Agent",
                  href: "/admin/TypeAgent",
                },
                {
                  text: "Fonctions",
                  href: "/admin/FonctionAgent",
                },
                {
                  text: "Catégorie Agent",
                  href: "/admin/CategorieAgent",
                },
                {
                  text: "Type RubriquesPaies",
                  href: "/admin/CategorieRubriquePers",
                },
                {//CategorieCirconstance
                  text: "Type Contrat",
                  href: "/admin/TypeContrat",
                },
                {//TypeStage
                  text: "Type Stage",
                  href: "/admin/TypeStage",
                },
                {//CategorieCirconstance
                  text: "Categorie Circontance",
                  href: "/admin/CategorieCirconstance",
                },
                {
                  text: "Type Circonstance",
                  href: "/admin/TypeCirconstance",
                },
                {
                  text: "Les Postes",
                  href: "/admin/Postes",
                },
                {
                  text: "Les Mutuelles",
                  href: "/admin/Mutuelle",
                },
                {
                  text: "Lieu Affectation",
                  href: "/admin/LieuAffectation",
                },
                {
                  text: "RubriquesPaies",
                  href: "/admin/RubriquePaie",
                },
                {
                  text: "Param. RubriquesPaies",
                  href: "/admin/ParametreRubrique",
                },
                {
                  text: "Departements",
                  href: "/admin/CategorieServicePers",
                },
                {
                  text: "Service Pers.",
                  href: "/admin/ServicePersonnel",
                },
                {
                  text: "Année Civile",
                  href: "/admin/Annee",
                },
                {
                  text: "Mois",
                  href: "/admin/Mois",
                },
                {
                  text: "PromotionAcadémique",
                  href: "/admin/Promotion",
                },
                {
                  text: "DomaineAcadémique",
                  href: "/admin/DomaineStage",
                },
                {
                  text: "OptionAcadémique",
                  href: "/admin/OptionStage",
                },
                {
                  text: "AnnéeAcadémique",
                  href: "/admin/AnneeStage",
                },
                {
                  text: "InstitutionsAC",
                  href: "/admin/Institution",
                },
                {
                  text: "Raison Familliale",
                  href: "/admin/RaisonFamilliale",
                }
          ],
          links_operation: [
            {
              icon: "store",
              text: "Pays",
              href: "/admin/pays",
            },
            {
              icon: "credit_card",
              text: "Provinces",
              href: "/admin/provinces",
            },

            {
              icon: "store",
              text: "Chef lieu",
              href: "/admin/ville",
            },
            {
              icon: "store",
              text: "Commune",
              href: "/admin/commune",
            },

            {
              icon: "store",
              text: "Quartier",
              href: "/admin/quartier",
            },

            {
              icon: "store",
              text: "Avenue",
              href: "/admin/avenue",
            },

            {
              icon: "store",
              text: "Forme juridique",
              href: "/admin/forme_juridique",
            },
            {
              text: "Statistique sur les blogs",
              href: "/admin/statistique_entreprise",
            },
            {
              icon: "store",
              text: "Territoire",
              href: "/admin/territoire",
            },

            {
              icon: "store",
              text: "Envoie SMS",
              href: "/admin/texto",
            },

            {
              icon: "store",
              text: "Statistique sur Les utilisateur",
              href: "/admin/statistique_user",
            },


            {
              icon: "api",
              text: "Témoignage",
              href: "/admin/temoignages",
            },

            {
              icon: "api",
              text: "Nos Valeurs",
              href: "/admin/valeur",
            },

            {
              icon: "api",
              text: "Nos Rôles",
              href: "/admin/role_service",
            },

            {
              icon: "api",
              text: "Nos Choix",
              href: "/admin/choix",
            },


            {
              icon: "credit_card",
              text: "Services",
              href: "/admin/service",
            },


            {
              icon: "api",
              text: "Decisions",
              href: "/admin/decision",
            },

            {
              icon: "api",
              text: "Avantage",
              href: "/admin/avantage",
            },
            {
              icon: "api",
              text: "Sous services",
              href: "/admin/sous_service",
            },






          ],
          links_systems: [
            {
              icon: "people",
              text: "Import.Presences",
              href: "/admin/ImportPresence",
            },
            {
              icon: "people",
              text: "Utilisateurs",
              href: "/admin/Users",
            },
            {
              icon: "api",
              text: "Entreprise",
              href: "/admin/liste_entreprise",
            },
            {
              icon: "api",
              text: "Privilège",
              href: "/admin/role",
            },
            {
              icon: "api",
              text: "Configuration Menu",
              href: "/admin/ListeMenu",
            },
            {
              icon: "api",
              text: "Historiques Infos.",
              href: "/admin/HistoriqueData",
            },
            {
              icon: "credit_card",
              text: "Contact pour info",
              href: "/admin/contact_info",
            },
            {
              icon: "api",
              text: "Configuration basique",
              href: "/admin/configure_basic",
            },
            { //Backups
              icon: "api",
              text: "Configuration du site",
              href: "/admin/configure_site",
            },
            { //Backups
              icon: "api",
              text: "Sauvegarde",
              href: "/admin/Backups",
            },

          ],
          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],
          listPersonnel: [
            {
              text: "RH",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Personnels",
                  href: "/admin/Agent",
                },
                // {
                //   text: "Contrats Encours",
                //   href: "/admin/ContratsEncours",
                // },
                {
                  text: "Contrats Encours",
                  href: "/admin/ContratActif",
                },
                {
                  text: "En Congé",
                  href: "/admin/ContratEnconge",
                },
                {
                  text: "Contrats Finis",
                  href: "/admin/ContratFini",
                },
                {
                  text: "Tous les Contrats",
                  href: "/admin/AllContrat",
                },
                {
                  text: "Stages Encours",
                  href: "/admin/StageEncours",
                },
                { //AllPresenceAgent
                  text: "Tous les Stages",
                  href: "/admin/AllStages",
                },
                { //AllPresenceAgent
                  text: "Toutes les Présences",
                  href: "/admin/AllPresenceAgent",
                },
                {
                  text: "Paiement Global",
                  href: "/admin/FichePaieGlobale",
                },
                {
                  text: "Paiement/Agent",
                  href: "/admin/FichePaie",
                },
                {
                  text: "Rapports Contrat",
                  href: "/admin/RapportContrat",
                },
                {
                  text: "Rapports Remuneration Agent",
                  href: "/admin/RapportsJour_Personnel",
                },
                {
                  text: "Param.SalaireBase",
                  href: "/admin/ParametreSalairebBase",
                },
                //ParametreSalairebBase
              ],
            },
          ],
          listPresence: [
            // {
            //   text: "Présences",
            //   icon: "mdi-account-settings",
            //   items: [                
            //     {
            //       text: "Aujourd'hui",
            //       href: "/admin/JourPresences",
            //     },
            //     {
            //       text: "Toutes les Présences",
            //       href: "/admin/AllPresenceAgent",
            //     }
            //   ],
            // },
          ],
          listCorresp: [
            // {
            //   text: "Correspondances",
            //   icon: "mdi-account-settings",
            //   items: [                
            //     {
            //       text: "Aujourd'hui",
            //       href: "/admin/JourCorrespondance",
            //     },
            //     {
            //       text: "Toutes les Corresp.",
            //       href: "/admin/AllCorrespondance",
            //     },
            //     {
            //       text: "Mes Correspondances",
            //       href: "/admin/UserCorrespondance",
            //     }
            //   ],
            // },
          ],
          listTimeSheet: [
            // {
            //   text: "Time Sheets",
            //   icon: "mdi-account-settings",
            //   items: [                
            //     {
            //       text: "Aujourd'hui",
            //       href: "/admin/JourTimeSheet",
            //     },
            //     {
            //       text: "Tous les TimeSheets.",
            //       href: "/admin/AllTimeSheet",
            //     },
            //     { //RapportTimeSheet
            //       text: "Mes TimeSheets",
            //       href: "/admin/UserTimeSheet",
            //     },
            //     { //RapportTimeSheet
            //       text: "Rapport TimeSheets",
            //       href: "/admin/RapportTimeSheet",
            //     }
            //   ],
            // },
          ],
          // listGroup: [
          //   {
          //     text: "Article",
          //     icon: "local_mall",
          //     items: [

          //       {

          //         text: "Catégorie d'article",
          //         href: "/admin/operation_catArticle",
          //       },
          //       {
          //         text: "Blog",
          //         href: "/admin/operation_blog",
          //       },

          //       {
          //         icon: "store",
          //         text: "Mot de la semaine",
          //         href: "/admin/week",
          //       },

          //     ],
          //   },
          // ],
          listCommancdes: [
            {
              text: "Commandes",
              icon: "mdi-cart-off",
              items: [ 
              { //Commandes
                text: "Creation Commandes",
                href: "/admin/Commandes",
              },
              {
                text: "Appro. par Commande",
                href: "/admin/ApprovCommandes",
              },               
              { //Commandes
                text: "Listes Commandes",
                href: "/admin/VenteEnteteCommande",
              },                
              { //Commandes
                text: "Paiement Fact. Fss.",
                href: "/admin/VenteEntetePaieCmd",
              },
              {
                text: "Clients",
                href: "/admin/ClientVente",
              },
              {
                text: "Produits",
                href: "/admin/Produits",
              },
              {
                icon: "store",
                text: "Fournisseurs",
                href: "/admin/Fournisseur",
              },
              {
                icon: "store",
                text: "Rapports",
                href: "/admin/RapportEntree",
              },
                  
              ],
            },
          ],
          listAppro: [
            {
              text: "Entrée Stock",
              icon: "mdi-cart-plus",
              items: [
              {
                text: "Création Appro.",
                href: "/admin/Approvisionnements",
              },
              {
                text: "Appro. par Commande",
                href: "/admin/ApprovCommandes",
              },
              {
                text: "Liste Appro.",
                href: "/admin/VenteEnteteEntree",
              },
              { //RapportEntree     RapportSortie
                text: "Création Transfert",
                href: "/admin/TransfertStock",
              },
              { //ApprovCommandes
                text: "Transfert/Usage",
                href: "/admin/TranfertUsage",
              },
              { //TransfertStock  TranfertUsage
                text: "Liste Transfert",
                href: "/admin/VenteEnteteTransfert",
              },
              {
                text: "Produits",
                href: "/admin/Produits",
              },
              {
                icon: "store",
                text: "Fournisseurs",
                href: "/admin/Fournisseur",
              },
              {
                icon: "groups",
                text: "Services Vente",
                href: "/admin/VenteServices",
              },
              { //TestExcel
                icon: "store",
                text: "Rapports",
                href: "/admin/RapportEntree",
              },
              { //TestExcel
                icon: "store",
                text: "Excel",
                href: "/admin/TestExcel",
              },
              ],
            },
          ],
          listVentes: [
            {
              text: "Vente Produit",
              icon: "mdi-cart",
              items: [
                {
                  text: "Création Vente",
                  href: "/admin/CreateVentes",
                },
                {
                  text: "Liste des Ventes",
                  href: "/admin/VenteEnteteVente",
                },
                {
                  text: "Paiement Ventes",
                  href: "/admin/VenteEntetePaieVente",
                },
                {
                  text: "Les Clients",
                  href: "/admin/ClientVente",
                },
                {
                  text: "Produits",
                  href: "/admin/Produits",
                },
                {
                  icon: "store",
                  text: "Fournisseurs",
                  href: "/admin/Fournisseur",
                },
                {
                  icon: "store",
                  text: "Rapports",
                  href: "/admin/RapportSortie",
                },
              ],
            },
          ],
          listFactureGroup: [
            {
              text: "Factures Groupées",
              icon: "mdi-cards",
              items: [
                {
                  text: "Création Fact.Groupée",
                  href: "/admin/CreateFactureGroupe",
                },
                {
                  text: "Liste des Factures",
                  href: "/admin/VenteEnteteFactureGroupe",
                },
                {
                  text: "Les Organisations",
                  href: "/admin/ClientVente",
                },
                {
                  icon: "store",
                  text: "Rapports",
                  href: "/admin/RapportsJour_Reservation",
                },
              ],
            },
          ],
          listUsage: [
            {
              text: "Sortie Produit",
              icon: "mdi-alert",
              items: [
                {
                  text: "Création Usage",
                  href: "/admin/CreateUsage",
                },
                {
                  text: "Liste des Usages",
                  href: "/admin/VenteEnteteUse",
                },                {
                  icon: "store",
                  text: "Rapports",
                  href: "/admin/RapportSortie",
                },
              ],
            },
          ],
          listCmdCuisine: [
            {
              text: "Commande Cuisine",
              icon: "mdi-album",
              items: [
                {
                  text: "Création Commande",
                  href: "/admin/CreateCommandeCuisine",
                },
                {
                  text: "Liste Commandes",
                  href: "/admin/VenteEnteteCuisine",
                },
                {
                  icon: "store",
                  text: "Rapports",
                  href: "/admin/RapportSortie",
                },
              ],
            },
          ],
          listInventaire: [
            {
              text: "Inventaires",
              icon: "mdi-alert-decagram",
              items: [
                {
                  text: "Création Inventaire",
                  href: "/admin/CreateInventaire",
                },
                { //VenteEnteteFactureGroupe          CreateFactureGroupe
                  text: "Liste Inventaires",
                  href: "/admin/VenteEnteteInventaire",
                },
                { 
                  text: "Ajustement Stock",
                  href: "/admin/CreateAjustement",
                },
                { 
                  text: "Innitialisation Stock",
                  href: "/admin/CreateRestoreProduct",
                },
                {
                  icon: "store",
                  text: "Rapports",
                  href: "/admin/RapportsJour_Vente",
                },
              ],
            },
          ],
          listProjets: [
            // {
            //   text: "Projets",
            //   icon: "mdi-projector-screen",
            //   items: [
            //     {
            //       text: "Partenaires",
            //       href: "/admin/PartenaireProjet",
            //     },
            //     {
            //       text: "Projets",
            //       href: "/admin/Projets",
            //     },
            //     // {
            //     //   icon: "store",
            //     //   text: "Rapports",
            //     //   href: "/admin/RapportsJour_Vente",
            //     // },
            //   ],
            // },
          ],
          listArchivages: [
            // {
            //   text: "Archivages",
            //   icon: "mdi-email-open",
            //   items: [              
            //     {
            //       text: "Archivages",
            //       href: "/admin/Archivages", 
            //     },
            //     {
            //       text: "Division",
            //       href: "/admin/DivisionArchive",
            //     },
            //     {
            //       text: "CategorieArch.",
            //       href: "/admin/CategorieArchivage",
            //     },
            //     {
            //       text: "Services",
            //       href: "/admin/ServiceArchivage",
            //     }
            //   ],
            // },
          ],
          listReservations: [
            {
              text: "Hebergement",
              icon: "mdi-home",
              items: [                
                { 
                  text: "Réservation Chambre",
                  href: "/admin/ReservationAll",
                },
                { 
                  text: "Clients",
                  href: "/admin/ClientHotel",
                },
                { //
                  text: "Location Appartement",
                  href: "/admin/LocationAppartementAll",
                },
                { 
                  text: "Salles",
                  href: "/admin/ClientVente",
                },
                { 
                  text: "Rapports",
                  href: "/admin/RapportsJour_Reservation",
                }

              ],
            },
          ],
          // listBillards: [
          //   {
          //     text: "Billards",
          //     icon: "mdi-gamepad",
          //     items: [                
          //       {
          //         text: "Billards",
          //         href: "/admin/ClientVente",
          //       }
          //     ],
          //   },
          // ],
          listFinances: [
            {
              text: "Finances",
              icon: "mdi-cards",
              items: [                
                {
                  text: "Recettes",
                  href: "/admin/recette",
                },
                {
                  text: "Etat de Besoin",
                  href: "/admin/EnteteEtatBesoin",
                },
                // { //DepenseAll
                //   text: "Bon d'Engagement",
                //   href: "/admin/EnteteBonEngagement",
                // },
                { //DepenseAll
                  text: "Depenses",
                  href: "/admin/DepenseAll",
                },
                {
                  text: "Cloture de la Caisse",
                  href: "/admin/Cloture_Caisse",
                },
                // {
                //   text: "Cloture de la Caisse Hotel",
                //   href: "/admin/Cloture_Caisse_Chambre",
                // },
                // {
                //   text: "Cloture de la Caisse Salle",
                //   href: "/admin/Cloture_Caisse_Salle",
                // },
                // {
                //   text: "Cloture de la Caisse Billards",
                //   href: "/admin/Cloture_Caisse_Billard",
                // },
                { 
                  text: "Comptabilité(Opé.)",
                  href: "/admin/EnteteOperationComptable",
                },
                { 
                  text: "Cloture de la Comptabilité",
                  href: "/admin/ClotureComptabilite",
                },
                {
                  text: "Rapport Comptabilité",
                  href: "/admin/RapportsComptabilite"
                  //Services
                },
                {
                  text: "Rapport Recettes/Depenses",
                  href: "/admin/RapportsJour_Caisse"
                },
                { //RapportContrat
                  text: "Rapports Remuneration Agent",
                  href: "/admin/RapportsJour_Personnel",
                },
                {
                  text: "Les Services",
                  href: "/admin/Services"
                }
              ],
            },
          ],
          // listLogistique: [
          //   {
          //     text: "Logistique",
          //     icon: "mdi-cart",
          //     items: [                
          //     {
          //         text: "Approvisionements",
          //         href: "/admin/LogEnteteEntree",
          //       },
          //       {
          //         text: "Sortie/Services",
          //         href: "/admin/LogEnteteSortie",
          //       },
          //       {
          //         text: "Requisitions",
          //         href: "/admin/LogEnteteRequisition",
          //       },
          //       {
          //         text: "Articles",
          //         href: "/admin/ProduitLog",
          //       },
          //       {
          //         text: "Fournisseur",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         text: "Categorie Art.",
          //         href: "/admin/categorieproduit",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Logistique",
          //       }

          //     ],
          //   },
          // ],

          // listVehicules: [
          //   { 
          //     text: "Véhicules",
          //     icon: "mdi-car",
          //     items: [                
          //       {
          //         text: "Mouvements des Véhicules",
          //         href: "/admin/CarEnteteMouvement",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vehicule",
          //       },
          //       {
          //         text: "Nos Véhicules",
          //         href: "/admin/CarVehicule",
          //       },
          //       {
          //         text: "Les Gammes",
          //         href: "/admin/CarProduit",
          //       },
          //       {
          //         text: "Les Fournisseurs",
          //         href: "/admin/CarProducteur",
          //       }
          //     ],
          //   },
          // ],
          // listSalon: [
          //   { 
          //     text: "Salon de Beauté",
          //     icon: "mdi-car",
          //     items: [              
          //        { 
          //          text: "Salon de Beauté",
          //          href: "/admin/SalonEnteteVente",
          //        },
          //        { 
          //          text: "Rapports(Salon)",
          //          href: "/admin/RapportsJour_VenteSalon",
          //        }
          //     ],
          //   },
          // ],
          links_systems_mouvement: [
          ],
          links_systems_mouvement_2: [
            // ProfilPatient
          ],
          links_systems_mouvement_3: [
          ],

          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };
      }
      else if (this.userData.id_role == 2) {        
        this.linkAdmin = {
          links: [
            // {
            //   icon: "mdi-microsoft-windows",
            //   text: "Tableau de bord",
            //   href: "/admin/dashboard",
            // },
            // {
            //   icon: "mdi-chart-pie",
            //   text: "Tableau de bord(Ese)",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "chat",
            //   text: "Chat",
            //   href: "/admin/chat",
            // },
          ],
          links_operation_2: [
            // {
            //   icon: "credit_card",
            //   text: "Carousel",
            //   href: "/admin/carousel",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Service",
            //   href: "/admin/operation_service",
            // },
            // {
            //   icon: "store",
            //   text: "Galérie",
            //   href: "/admin/operation_galery",
            // },
            // {
            //   icon: "store",
            //   text: "Vidéo",
            //   href: "/admin/operation_video",
            // },
            // {
            //   icon: "store",
            //   text: "Partenaire",
            //   href: "/admin/operation_partenaire",
            // },

            // {
            //   icon: "store",
            //   text: "Notre famille",
            //   href: "/admin/operation_team",
            // },

          ],
          links_finance: [
            // {
            //   icon: "groups",
            //   text: "Classes",
            //   href: "/admin/ClassesFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Comptes",
            //   href: "/admin/CompteFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Sous Comptes",
            //   href: "/admin/SousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "SSous Comptes",
            //   href: "/admin/SSousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Compte",
            //   href: "/admin/TypeCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Config. Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Position",
            //   href: "/admin/TypePosition",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Opération",
            //   href: "/admin/TypeOperation",
            // },
            // {
            //   text: "Rubriques",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Caisse&Banque",
            //   href: "/admin/Banque",
            // },
            // {
            //   text: "ModePaie",
            //   href: "/admin/modepaie",
            // },
            // {
            //   icon: "groups",
            //   text: "Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Services Treseorerie",
            //   href: "/admin/Provenance",
            // },
            // {
            //   icon: "groups",
            //   text: "Cat. Rubriques",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   icon: "groups",
            //   text: "Rubriques Depenses",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   icon: "groups",
            //   text: "Blocs",
            //   href: "/admin/Blocs",
            // }

          ],
          links_vente: [
            // {
            //   icon: "groups",
            //   text: "CatégorieProduit",
            //   href: "/admin/CategorieProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Emplacements",
            //   href: "/admin/Emplacements",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Logistique",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Salon",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "CatégorieClient",
            //   href: "/admin/CategorieClient",
            // }
          ],
          links_tresorerie: [
            // {
            //   text: "Rubriques Depenses",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Cat.Rubriques EB",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   text: "Rubriques EB",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   text: "Blocs(Finances)",
            //   href: "/admin/Blocs",
            // },
            // {
            //   text: "Les Services(Finances)",
            //   href: "/admin/Provenance",
            // }
          ],
          links_hotel: [
            // {
            //   text: "ClasseChambre",
            //   href: "/admin/ClasseChambre",
            // },
            // {
            //   text: "Chambres",
            //   href: "/admin/Chambre",
            // },
            // { //SalonProduit
            //   text: "Salles",
            //   href: "/admin/Salle",
            // },
            // { //SalonProduit
            //   text: "Services Salon",
            //   href: "/admin/SalonProduit",
            // }
          ],
          links_personne: [
                // {
                //   text: "Type Agent",
                //   href: "/admin/TypeAgent",
                // },
                // {
                //   text: "Fonctions",
                //   href: "/admin/FonctionAgent",
                // },
                // {
                //   text: "Catégorie Agent",
                //   href: "/admin/CategorieAgent",
                // },
                // {
                //   text: "Type RubriquesPaies",
                //   href: "/admin/CategorieRubriquePers",
                // },
                // {//CategorieCirconstance
                //   text: "Type Contrat",
                //   href: "/admin/TypeContrat",
                // },
                // {//TypeStage
                //   text: "Type Stage",
                //   href: "/admin/TypeStage",
                // },
                // {//CategorieCirconstance
                //   text: "Categorie Circontance",
                //   href: "/admin/CategorieCirconstance",
                // },
                // {
                //   text: "Type Circonstance",
                //   href: "/admin/TypeCirconstance",
                // },
                // {
                //   text: "Les Postes",
                //   href: "/admin/Postes",
                // },
                // {
                //   text: "Les Mutuelles",
                //   href: "/admin/Mutuelle",
                // },
                // {
                //   text: "Lieu Affectation",
                //   href: "/admin/LieuAffectation",
                // },
                // {
                //   text: "RubriquesPaies",
                //   href: "/admin/RubriquePaie",
                // },
                // {
                //   text: "Param. RubriquesPaies",
                //   href: "/admin/ParametreRubrique",
                // },
                // {
                //   text: "Catégorie Service",
                //   href: "/admin/CategorieServicePers",
                // },
                // {
                //   text: "Service Pers.",
                //   href: "/admin/ServicePersonnel",
                // },
                // {
                //   text: "Année Civile",
                //   href: "/admin/Annee",
                // },
                // {
                //   text: "Mois",
                //   href: "/admin/Mois",
                // },
                // {
                //   text: "PromotionAcadémique",
                //   href: "/admin/Promotion",
                // },
                // {
                //   text: "DomaineAcadémique",
                //   href: "/admin/DomaineStage",
                // },
                // {
                //   text: "OptionAcadémique",
                //   href: "/admin/OptionStage",
                // },
                // {
                //   text: "AnnéeAcadémique",
                //   href: "/admin/AnneeStage",
                // },
                // {
                //   text: "InstitutionsAC",
                //   href: "/admin/Institution",
                // },
                // {
                //   text: "Raison Familliale",
                //   href: "/admin/RaisonFamilliale",
                // }
          ],
          links_operation: [
            // {
            //   icon: "store",
            //   text: "Pays",
            //   href: "/admin/pays",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Provinces",
            //   href: "/admin/provinces",
            // },

            // {
            //   icon: "store",
            //   text: "Chef lieu",
            //   href: "/admin/ville",
            // },
            // {
            //   icon: "store",
            //   text: "Commune",
            //   href: "/admin/commune",
            // },

            // {
            //   icon: "store",
            //   text: "Quartier",
            //   href: "/admin/quartier",
            // },

            // {
            //   icon: "store",
            //   text: "Avenue",
            //   href: "/admin/avenue",
            // },

            // {
            //   icon: "store",
            //   text: "Forme juridique",
            //   href: "/admin/forme_juridique",
            // },
            // {
            //   text: "Statistique sur les blogs",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "store",
            //   text: "Territoire",
            //   href: "/admin/territoire",
            // },

            // {
            //   icon: "store",
            //   text: "Envoie SMS",
            //   href: "/admin/texto",
            // },

            // {
            //   icon: "store",
            //   text: "Statistique sur Les utilisateur",
            //   href: "/admin/statistique_user",
            // },


            // {
            //   icon: "api",
            //   text: "Témoignage",
            //   href: "/admin/temoignages",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Valeurs",
            //   href: "/admin/valeur",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Rôles",
            //   href: "/admin/role_service",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Choix",
            //   href: "/admin/choix",
            // },


            // {
            //   icon: "credit_card",
            //   text: "Services",
            //   href: "/admin/service",
            // },


            // {
            //   icon: "api",
            //   text: "Decisions",
            //   href: "/admin/decision",
            // },

            // {
            //   icon: "api",
            //   text: "Avantage",
            //   href: "/admin/avantage",
            // },
            // {
            //   icon: "api",
            //   text: "Sous services",
            //   href: "/admin/sous_service",
            // },
            
          ],
          links_systems: [
            // {
            //   icon: "people",
            //   text: "Utilisateurs",
            //   href: "/admin/Users",
            // },
            // {
            //   icon: "api",
            //   text: "Entreprise",
            //   href: "/admin/liste_entreprise",
            // },
            // {
            //   icon: "api",
            //   text: "Privilège",
            //   href: "/admin/role",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration Menu",
            //   href: "/admin/ListeMenu",
            // },
            // {
            //   icon: "api",
            //   text: "Historiques Infos.",
            //   href: "/admin/HistoriqueData",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Contact pour info",
            //   href: "/admin/contact_info",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration basique",
            //   href: "/admin/configure_basic",
            // },

            // {
            //   icon: "api",
            //   text: "Configuration du site",
            //   href: "/admin/configure_site",
            // },

          ],
          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],
          listPersonnel: [
          {
              text: "RH",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Personnels",
                  href: "/admin/Agent",
                },
                {
                  text: "Contrats Encours",
                  href: "/admin/ContratActif",
                },
                {
                  text: "En Congé",
                  href: "/admin/ContratEnconge",
                },
                {
                  text: "Contrats Finis",
                  href: "/admin/ContratFini",
                },
                {
                  text: "Tous les Contrats",
                  href: "/admin/AllContrat",
                },
                {
                  text: "Stages Encours",
                  href: "/admin/StageEncours",
                },
                { //AllPresenceAgent
                  text: "Tous les Stages",
                  href: "/admin/AllStages",
                },
                { //AllPresenceAgent
                  text: "Toutes les Présences",
                  href: "/admin/AllPresenceAgent",
                },
                {
                  text: "Paiement Global",
                  href: "/admin/FichePaieGlobale",
                },
                {
                  text: "Paiement/Agent",
                  href: "/admin/FichePaie",
                },
                {
                  text: "Rapports Contrat",
                  href: "/admin/RapportContrat",
                },
                {
                  text: "Rapports Remuneration Agent",
                  href: "/admin/RapportsJour_Personnel",
                },
                {
                  text: "Param.SalaireBase",
                  href: "/admin/ParametreSalairebBase",
                },
                //ParametreSalairebBase
              ],
            },
          ],
          listPresence: [
            {
              text: "Présences",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Aujourd'hui",
                  href: "/admin/JourPresences",
                },
                {
                  text: "Toutes les Présences",
                  href: "/admin/AllPresenceAgent",
                }
              ],
            },
          ],
          listCorresp: [
            {
              text: "Correspondances",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Aujourd'hui",
                  href: "/admin/JourCorrespondance",
                },
                {
                  text: "Toutes les Corresp.",
                  href: "/admin/AllCorrespondance",
                },
                {
                  text: "Mes Correspondances",
                  href: "/admin/UserCorrespondance",
                }
              ],
            },
          ],
          listTimeSheet: [
            {
              text: "Time Sheets",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Aujourd'hui",
                  href: "/admin/JourTimeSheet",
                },
                {
                  text: "Tous les TimeSheets.",
                  href: "/admin/AllTimeSheet",
                },
                {
                  text: "Mes TimeSheets",
                  href: "/admin/UserTimeSheet",
                }
              ],
            },
          ],
          // listGroup: [
          //   {
          //     text: "Article",
          //     icon: "local_mall",
          //     items: [
          //       {
          //         text: "Catégorie d'article",
          //         href: "/admin/operation_catArticle",
          //       },
          //       {
          //         text: "Blog",
          //         href: "/admin/operation_blog",
          //       },

          //       {
          //         icon: "store",
          //         text: "Mot de la semaine",
          //         href: "/admin/week",
          //       },

          //     ],
          //   },
          // ],
          // listVentes: [
          //   {
          //     text: "Ventes & Stock",
          //     icon: "mdi-cart",
          //     items: [
          //       {
          //         text: "Ventes",
          //         href: "/admin/VenteEnteteVente",
          //       },
          //       {
          //         text: "Clients",
          //         href: "/admin/ClientVente",
          //       },
          //       {
          //         text: "Approvisionnements",
          //         href: "/admin/VenteEnteteEntree",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/VenteEnteteCommande",
          //       },
          //       {
          //         text: "Produits",
          //         href: "/admin/Produits",
          //       },
          //       {
          //         icon: "store",
          //         text: "Fournisseurs",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         icon: "store",
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vente",
          //       },
          //     ],
          //   },
          // ],
          listProjets: [
            {
              text: "Projets",
              icon: "mdi-projector-screen",
              items: [
                {
                  text: "Partenaires",
                  href: "/admin/PartenaireProjet",
                },
                {
                  text: "Projets",
                  href: "/admin/Projets",
                },
                // {
                //   icon: "store",
                //   text: "Rapports",
                //   href: "/admin/RapportsJour_Vente",
                // },
              ],
            },
          ],
          listArchivages: [
          {
              text: "Archivages",
              icon: "mdi-email-open",
              items: [              
                {
                  text: "Archivages",
                  href: "/admin/Archivages", 
                },
                // {
                //   text: "Division",
                //   href: "/admin/DivisionArchive",
                // },
                // {
                //   text: "CategorieArch.",
                //   href: "/admin/CategorieArchivage",
                // },
                // {
                //   text: "Services",
                //   href: "/admin/ServiceArchivage",
                // }
              ],
            },
          ],
          // listReservations: [
          //   {
          //     text: "Resérvations",
          //     icon: "mdi-home",
          //     items: [

          //       {
          //         text: "Chambres",
          //         href: "/admin/ClientHotel",
          //       },
          //       { 
          //         text: "Salles",
          //         href: "/admin/ClientVente",
          //       },
          //       { 
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Reservation",
          //       }

          //     ],
          //   },
          // ],
          // listBillards: [
          //   {
          //     text: "Billards",
          //     icon: "mdi-gamepad",
          //     items: [                
          //       {
          //         text: "Billards",
          //         href: "/admin/ClientVente",
          //       }
          //     ],
          //   },
          // ],
          // listFinances: [
          //   {
          //     text: "Finances",
          //     icon: "mdi-cards",
          //     items: [                
          //       {
          //         text: "Recettes",
          //         href: "/admin/recette",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/EnteteEtatBesoin",
          //       },
          //       {
          //         text: "Bon d'Engagement",
          //         href: "/admin/EnteteBonEngagement",
          //       },
          //       {
          //         text: "Cloture de la Caisse",
          //         href: "/admin/Cloture_Caisse",
          //       },
          //       // {
          //       //   text: "Cloture de la Caisse Hotel",
          //       //   href: "/admin/Cloture_Caisse_Chambre",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Salle",
          //       //   href: "/admin/Cloture_Caisse_Salle",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Billards",
          //       //   href: "/admin/Cloture_Caisse_Billard",
          //       // },
          //       { 
          //         text: "Comptabilité(Opé.)",
          //         href: "/admin/EnteteOperationComptable",
          //       },
          //       { 
          //         text: "Cloture de la Comptabilité",
          //         href: "/admin/ClotureComptabilite",
          //       },
          //       {
          //         text: "Rapport Comptabilité",
          //         href: "/admin/RapportsComptabilite"
          //         //Services
          //       },
          //       {
          //         text: "Rapport Recettes/Depenses",
          //         href: "/admin/RapportsJour_Caisse"
          //       },
          //       { //RapportContrat
          //         text: "Rapports Remuneration Agent",
          //         href: "/admin/RapportsJour_Personnel",
          //       },
          //       {
          //         text: "Les Services",
          //         href: "/admin/Services"
          //       }
          //     ],
          //   },
          // ],
          // listLogistique: [
          //   {
          //     text: "Logistique",
          //     icon: "mdi-cart",
          //     items: [                
          //     {
          //         text: "Approvisionements",
          //         href: "/admin/LogEnteteEntree",
          //       },
          //       {
          //         text: "Sortie/Services",
          //         href: "/admin/LogEnteteSortie",
          //       },
          //       {
          //         text: "Requisitions",
          //         href: "/admin/LogEnteteRequisition",
          //       },
          //       {
          //         text: "Articles",
          //         href: "/admin/ProduitLog",
          //       },
          //       {
          //         text: "Fournisseur",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         text: "Categorie Art.",
          //         href: "/admin/categorieproduit",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Logistique",
          //       }

          //     ],
          //   },
          // ],

          // listVehicules: [
          //   { 
          //     text: "Véhicules",
          //     icon: "mdi-car",
          //     items: [                
          //       {
          //         text: "Mouvements des Véhicules",
          //         href: "/admin/CarEnteteMouvement",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vehicule",
          //       },
          //       {
          //         text: "Nos Véhicules",
          //         href: "/admin/CarVehicule",
          //       },
          //       {
          //         text: "Les Gammes",
          //         href: "/admin/CarProduit",
          //       },
          //       {
          //         text: "Les Fournisseurs",
          //         href: "/admin/CarProducteur",
          //       }
          //     ],
          //   },
          // ],
          // listSalon: [
          //   { 
          //     text: "Salon de Beauté",
          //     icon: "mdi-car",
          //     items: [              
          //        { 
          //          text: "Salon de Beauté",
          //          href: "/admin/SalonEnteteVente",
          //        },
          //        { 
          //          text: "Rapports(Salon)",
          //          href: "/admin/RapportsJour_VenteSalon",
          //        }
          //     ],
          //   },
          // ],
          links_systems_mouvement: [
          ],
          links_systems_mouvement_2: [
            // ProfilPatient
          ],
          links_systems_mouvement_3: [
          ],

          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };
      }
      else if (this.userData.id_role == 3) {
        this.linkAdmin = {
          links: [
            // {
            //   icon: "mdi-microsoft-windows",
            //   text: "Tableau de bord",
            //   href: "/admin/dashboard",
            // },
            // {
            //   icon: "mdi-chart-pie",
            //   text: "Tableau de bord(Ese)",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "chat",
            //   text: "Chat",
            //   href: "/admin/chat",
            // },
          ],
          links_operation_2: [
            // {
            //   icon: "credit_card",
            //   text: "Carousel",
            //   href: "/admin/carousel",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Service",
            //   href: "/admin/operation_service",
            // },
            // {
            //   icon: "store",
            //   text: "Galérie",
            //   href: "/admin/operation_galery",
            // },
            // {
            //   icon: "store",
            //   text: "Vidéo",
            //   href: "/admin/operation_video",
            // },
            // {
            //   icon: "store",
            //   text: "Partenaire",
            //   href: "/admin/operation_partenaire",
            // },

            // {
            //   icon: "store",
            //   text: "Notre famille",
            //   href: "/admin/operation_team",
            // },

          ],
          links_finance: [
            // {
            //   icon: "groups",
            //   text: "Classes",
            //   href: "/admin/ClassesFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Comptes",
            //   href: "/admin/CompteFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Sous Comptes",
            //   href: "/admin/SousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "SSous Comptes",
            //   href: "/admin/SSousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Compte",
            //   href: "/admin/TypeCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Config. Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Position",
            //   href: "/admin/TypePosition",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Opération",
            //   href: "/admin/TypeOperation",
            // },
            // {
            //   text: "Rubriques",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Caisse&Banque",
            //   href: "/admin/Banque",
            // },
            // {
            //   text: "ModePaie",
            //   href: "/admin/modepaie",
            // },
            // {
            //   icon: "groups",
            //   text: "Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Services Treseorerie",
            //   href: "/admin/Provenance",
            // },
            // {
            //   icon: "groups",
            //   text: "Cat. Rubriques",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   icon: "groups",
            //   text: "Rubriques Depenses",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   icon: "groups",
            //   text: "Blocs",
            //   href: "/admin/Blocs",
            // }

          ],
          links_vente: [
            // {
            //   icon: "groups",
            //   text: "CatégorieProduit",
            //   href: "/admin/CategorieProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Emplacements",
            //   href: "/admin/Emplacements",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Logistique",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Salon",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "CatégorieClient",
            //   href: "/admin/CategorieClient",
            // }
          ],
          links_tresorerie: [
            // {
            //   text: "Rubriques Depenses",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Cat.Rubriques EB",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   text: "Rubriques EB",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   text: "Blocs(Finances)",
            //   href: "/admin/Blocs",
            // },
            // {
            //   text: "Les Services(Finances)",
            //   href: "/admin/Provenance",
            // }
          ],
          links_hotel: [
            // {
            //   text: "ClasseChambre",
            //   href: "/admin/ClasseChambre",
            // },
            // {
            //   text: "Chambres",
            //   href: "/admin/Chambre",
            // },
            // { //SalonProduit
            //   text: "Salles",
            //   href: "/admin/Salle",
            // },
            // { //SalonProduit
            //   text: "Services Salon",
            //   href: "/admin/SalonProduit",
            // }
          ],
          links_personne: [
                // {
                //   text: "Type Agent",
                //   href: "/admin/TypeAgent",
                // },
                // {
                //   text: "Fonctions",
                //   href: "/admin/FonctionAgent",
                // },
                // {
                //   text: "Catégorie Agent",
                //   href: "/admin/CategorieAgent",
                // },
                // {
                //   text: "Type RubriquesPaies",
                //   href: "/admin/CategorieRubriquePers",
                // },
                // {//CategorieCirconstance
                //   text: "Type Contrat",
                //   href: "/admin/TypeContrat",
                // },
                // {//TypeStage
                //   text: "Type Stage",
                //   href: "/admin/TypeStage",
                // },
                // {//CategorieCirconstance
                //   text: "Categorie Circontance",
                //   href: "/admin/CategorieCirconstance",
                // },
                // {
                //   text: "Type Circonstance",
                //   href: "/admin/TypeCirconstance",
                // },
                // {
                //   text: "Les Postes",
                //   href: "/admin/Postes",
                // },
                // {
                //   text: "Les Mutuelles",
                //   href: "/admin/Mutuelle",
                // },
                // {
                //   text: "Lieu Affectation",
                //   href: "/admin/LieuAffectation",
                // },
                // {
                //   text: "RubriquesPaies",
                //   href: "/admin/RubriquePaie",
                // },
                // {
                //   text: "Param. RubriquesPaies",
                //   href: "/admin/ParametreRubrique",
                // },
                // {
                //   text: "Catégorie Service",
                //   href: "/admin/CategorieServicePers",
                // },
                // {
                //   text: "Service Pers.",
                //   href: "/admin/ServicePersonnel",
                // },
                // {
                //   text: "Année Civile",
                //   href: "/admin/Annee",
                // },
                // {
                //   text: "Mois",
                //   href: "/admin/Mois",
                // },
                // {
                //   text: "PromotionAcadémique",
                //   href: "/admin/Promotion",
                // },
                // {
                //   text: "DomaineAcadémique",
                //   href: "/admin/DomaineStage",
                // },
                // {
                //   text: "OptionAcadémique",
                //   href: "/admin/OptionStage",
                // },
                // {
                //   text: "AnnéeAcadémique",
                //   href: "/admin/AnneeStage",
                // },
                // {
                //   text: "InstitutionsAC",
                //   href: "/admin/Institution",
                // },
                // {
                //   text: "Raison Familliale",
                //   href: "/admin/RaisonFamilliale",
                // }
          ],
          links_operation: [
            // {
            //   icon: "store",
            //   text: "Pays",
            //   href: "/admin/pays",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Provinces",
            //   href: "/admin/provinces",
            // },

            // {
            //   icon: "store",
            //   text: "Chef lieu",
            //   href: "/admin/ville",
            // },
            // {
            //   icon: "store",
            //   text: "Commune",
            //   href: "/admin/commune",
            // },

            // {
            //   icon: "store",
            //   text: "Quartier",
            //   href: "/admin/quartier",
            // },

            // {
            //   icon: "store",
            //   text: "Avenue",
            //   href: "/admin/avenue",
            // },

            // {
            //   icon: "store",
            //   text: "Forme juridique",
            //   href: "/admin/forme_juridique",
            // },
            // {
            //   text: "Statistique sur les blogs",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "store",
            //   text: "Territoire",
            //   href: "/admin/territoire",
            // },

            // {
            //   icon: "store",
            //   text: "Envoie SMS",
            //   href: "/admin/texto",
            // },

            // {
            //   icon: "store",
            //   text: "Statistique sur Les utilisateur",
            //   href: "/admin/statistique_user",
            // },


            // {
            //   icon: "api",
            //   text: "Témoignage",
            //   href: "/admin/temoignages",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Valeurs",
            //   href: "/admin/valeur",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Rôles",
            //   href: "/admin/role_service",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Choix",
            //   href: "/admin/choix",
            // },


            // {
            //   icon: "credit_card",
            //   text: "Services",
            //   href: "/admin/service",
            // },


            // {
            //   icon: "api",
            //   text: "Decisions",
            //   href: "/admin/decision",
            // },

            // {
            //   icon: "api",
            //   text: "Avantage",
            //   href: "/admin/avantage",
            // },
            // {
            //   icon: "api",
            //   text: "Sous services",
            //   href: "/admin/sous_service",
            // },
            
          ],
          links_systems: [
            // {
            //   icon: "people",
            //   text: "Utilisateurs",
            //   href: "/admin/Users",
            // },
            // {
            //   icon: "api",
            //   text: "Entreprise",
            //   href: "/admin/liste_entreprise",
            // },
            // {
            //   icon: "api",
            //   text: "Privilège",
            //   href: "/admin/role",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration Menu",
            //   href: "/admin/ListeMenu",
            // },
            // {
            //   icon: "api",
            //   text: "Historiques Infos.",
            //   href: "/admin/HistoriqueData",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Contact pour info",
            //   href: "/admin/contact_info",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration basique",
            //   href: "/admin/configure_basic",
            // },

            // {
            //   icon: "api",
            //   text: "Configuration du site",
            //   href: "/admin/configure_site",
            // },

          ],
          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],
          listPersonnel: [
          {
              text: "RH",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Personnels",
                  href: "/admin/Agent",
                },
                {
                  text: "Contrats Encours",
                  href: "/admin/ContratActif",
                },
                {
                  text: "En Congé",
                  href: "/admin/ContratEnconge",
                },
                {
                  text: "Contrats Finis",
                  href: "/admin/ContratFini",
                },
                {
                  text: "Tous les Contrats",
                  href: "/admin/AllContrat",
                },
                {
                  text: "Stages Encours",
                  href: "/admin/StageEncours",
                },
                { //AllPresenceAgent
                  text: "Tous les Stages",
                  href: "/admin/AllStages",
                },
                { //AllPresenceAgent
                  text: "Toutes les Présences",
                  href: "/admin/AllPresenceAgent",
                },
                {
                  text: "Paiement Global",
                  href: "/admin/FichePaieGlobale",
                },
                {
                  text: "Paiement/Agent",
                  href: "/admin/FichePaie",
                },
                {
                  text: "Rapports Contrat",
                  href: "/admin/RapportContrat",
                },
                {
                  text: "Rapports Remuneration Agent",
                  href: "/admin/RapportsJour_Personnel",
                },
                {
                  text: "Param.SalaireBase",
                  href: "/admin/ParametreSalairebBase",
                },
                //ParametreSalairebBase
              ],
            },
          ],
          listPresence: [
            {
              text: "Présences",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Aujourd'hui",
                  href: "/admin/JourPresences",
                },
                {
                  text: "Toutes les Présences",
                  href: "/admin/AllPresenceAgent",
                }
              ],
            },
          ],
          listCorresp: [
            {
              text: "Correspondances",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Aujourd'hui",
                  href: "/admin/JourCorrespondance",
                },
                {
                  text: "Toutes les Corresp.",
                  href: "/admin/AllCorrespondance",
                },
                {
                  text: "Mes Correspondances",
                  href: "/admin/UserCorrespondance",
                }
              ],
            },
          ],
          listTimeSheet: [
            {
              text: "Time Sheets",
              icon: "mdi-account-settings",
              items: [                
                {
                  text: "Aujourd'hui",
                  href: "/admin/JourTimeSheet",
                },
                {
                  text: "Tous les TimeSheets.",
                  href: "/admin/AllTimeSheet",
                },
                {
                  text: "Mes TimeSheets",
                  href: "/admin/UserTimeSheet",
                }
              ],
            },
          ],
          // listGroup: [
          //   {
          //     text: "Article",
          //     icon: "local_mall",
          //     items: [
          //       {
          //         text: "Catégorie d'article",
          //         href: "/admin/operation_catArticle",
          //       },
          //       {
          //         text: "Blog",
          //         href: "/admin/operation_blog",
          //       },

          //       {
          //         icon: "store",
          //         text: "Mot de la semaine",
          //         href: "/admin/week",
          //       },

          //     ],
          //   },
          // ],
          // listVentes: [
          //   {
          //     text: "Ventes & Stock",
          //     icon: "mdi-cart",
          //     items: [
          //       {
          //         text: "Ventes",
          //         href: "/admin/VenteEnteteVente",
          //       },
          //       {
          //         text: "Clients",
          //         href: "/admin/ClientVente",
          //       },
          //       {
          //         text: "Approvisionnements",
          //         href: "/admin/VenteEnteteEntree",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/VenteEnteteCommande",
          //       },
          //       {
          //         text: "Produits",
          //         href: "/admin/Produits",
          //       },
          //       {
          //         icon: "store",
          //         text: "Fournisseurs",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         icon: "store",
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vente",
          //       },
          //     ],
          //   },
          // ],
          listProjets: [
            {
              text: "Projets",
              icon: "mdi-projector-screen",
              items: [
                {
                  text: "Partenaires",
                  href: "/admin/PartenaireProjet",
                },
                {
                  text: "Projets",
                  href: "/admin/Projets",
                },
                // {
                //   icon: "store",
                //   text: "Rapports",
                //   href: "/admin/RapportsJour_Vente",
                // },
              ],
            },
          ],
          listArchivages: [
          {
              text: "Archivages",
              icon: "mdi-email-open",
              items: [              
                {
                  text: "Archivages",
                  href: "/admin/Archivages", 
                },
                // {
                //   text: "Division",
                //   href: "/admin/DivisionArchive",
                // },
                // {
                //   text: "CategorieArch.",
                //   href: "/admin/CategorieArchivage",
                // },
                // {
                //   text: "Services",
                //   href: "/admin/ServiceArchivage",
                // }
              ],
            },
          ],
          // listReservations: [
          //   {
          //     text: "Resérvations",
          //     icon: "mdi-home",
          //     items: [

          //       {
          //         text: "Chambres",
          //         href: "/admin/ClientHotel",
          //       },
          //       { 
          //         text: "Salles",
          //         href: "/admin/ClientVente",
          //       },
          //       { 
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Reservation",
          //       }

          //     ],
          //   },
          // ],
          // listBillards: [
          //   {
          //     text: "Billards",
          //     icon: "mdi-gamepad",
          //     items: [                
          //       {
          //         text: "Billards",
          //         href: "/admin/ClientVente",
          //       }
          //     ],
          //   },
          // ],
          // listFinances: [
          //   {
          //     text: "Finances",
          //     icon: "mdi-cards",
          //     items: [                
          //       {
          //         text: "Recettes",
          //         href: "/admin/recette",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/EnteteEtatBesoin",
          //       },
          //       {
          //         text: "Bon d'Engagement",
          //         href: "/admin/EnteteBonEngagement",
          //       },
          //       {
          //         text: "Cloture de la Caisse",
          //         href: "/admin/Cloture_Caisse",
          //       },
          //       // {
          //       //   text: "Cloture de la Caisse Hotel",
          //       //   href: "/admin/Cloture_Caisse_Chambre",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Salle",
          //       //   href: "/admin/Cloture_Caisse_Salle",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Billards",
          //       //   href: "/admin/Cloture_Caisse_Billard",
          //       // },
          //       { 
          //         text: "Comptabilité(Opé.)",
          //         href: "/admin/EnteteOperationComptable",
          //       },
          //       { 
          //         text: "Cloture de la Comptabilité",
          //         href: "/admin/ClotureComptabilite",
          //       },
          //       {
          //         text: "Rapport Comptabilité",
          //         href: "/admin/RapportsComptabilite"
          //         //Services
          //       },
          //       {
          //         text: "Rapport Recettes/Depenses",
          //         href: "/admin/RapportsJour_Caisse"
          //       },
          //       { //RapportContrat
          //         text: "Rapports Remuneration Agent",
          //         href: "/admin/RapportsJour_Personnel",
          //       },
          //       {
          //         text: "Les Services",
          //         href: "/admin/Services"
          //       }
          //     ],
          //   },
          // ],
          // listLogistique: [
          //   {
          //     text: "Logistique",
          //     icon: "mdi-cart",
          //     items: [                
          //     {
          //         text: "Approvisionements",
          //         href: "/admin/LogEnteteEntree",
          //       },
          //       {
          //         text: "Sortie/Services",
          //         href: "/admin/LogEnteteSortie",
          //       },
          //       {
          //         text: "Requisitions",
          //         href: "/admin/LogEnteteRequisition",
          //       },
          //       {
          //         text: "Articles",
          //         href: "/admin/ProduitLog",
          //       },
          //       {
          //         text: "Fournisseur",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         text: "Categorie Art.",
          //         href: "/admin/categorieproduit",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Logistique",
          //       }

          //     ],
          //   },
          // ],

          // listVehicules: [
          //   { 
          //     text: "Véhicules",
          //     icon: "mdi-car",
          //     items: [                
          //       {
          //         text: "Mouvements des Véhicules",
          //         href: "/admin/CarEnteteMouvement",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vehicule",
          //       },
          //       {
          //         text: "Nos Véhicules",
          //         href: "/admin/CarVehicule",
          //       },
          //       {
          //         text: "Les Gammes",
          //         href: "/admin/CarProduit",
          //       },
          //       {
          //         text: "Les Fournisseurs",
          //         href: "/admin/CarProducteur",
          //       }
          //     ],
          //   },
          // ],
          // listSalon: [
          //   { 
          //     text: "Salon de Beauté",
          //     icon: "mdi-car",
          //     items: [              
          //        { 
          //          text: "Salon de Beauté",
          //          href: "/admin/SalonEnteteVente",
          //        },
          //        { 
          //          text: "Rapports(Salon)",
          //          href: "/admin/RapportsJour_VenteSalon",
          //        }
          //     ],
          //   },
          // ],
          links_systems_mouvement: [
          ],
          links_systems_mouvement_2: [
            // ProfilPatient
          ],
          links_systems_mouvement_3: [
          ],

          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };
      }
      else if (this.userData.id_role == 4) {
        this.linkAdmin = {
          links: [
            // {
            //   icon: "mdi-microsoft-windows",
            //   text: "Tableau de bord",
            //   href: "/admin/dashboard",
            // },
            // {
            //   icon: "mdi-chart-pie",
            //   text: "Tableau de bord(Ese)",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "chat",
            //   text: "Chat",
            //   href: "/admin/chat",
            // },
          ],
          links_operation_2: [
            // {
            //   icon: "credit_card",
            //   text: "Carousel",
            //   href: "/admin/carousel",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Service",
            //   href: "/admin/operation_service",
            // },
            // {
            //   icon: "store",
            //   text: "Galérie",
            //   href: "/admin/operation_galery",
            // },
            // {
            //   icon: "store",
            //   text: "Vidéo",
            //   href: "/admin/operation_video",
            // },
            // {
            //   icon: "store",
            //   text: "Partenaire",
            //   href: "/admin/operation_partenaire",
            // },

            // {
            //   icon: "store",
            //   text: "Notre famille",
            //   href: "/admin/operation_team",
            // },

          ],
          links_finance: [
            // {
            //   icon: "groups",
            //   text: "Classes",
            //   href: "/admin/ClassesFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Comptes",
            //   href: "/admin/CompteFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Sous Comptes",
            //   href: "/admin/SousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "SSous Comptes",
            //   href: "/admin/SSousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Compte",
            //   href: "/admin/TypeCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Config. Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Position",
            //   href: "/admin/TypePosition",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Opération",
            //   href: "/admin/TypeOperation",
            // },
            // {
            //   text: "Rubriques",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Caisse&Banque",
            //   href: "/admin/Banque",
            // },
            // {
            //   text: "ModePaie",
            //   href: "/admin/modepaie",
            // },
            // {
            //   icon: "groups",
            //   text: "Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Services Treseorerie",
            //   href: "/admin/Provenance",
            // },
            // {
            //   icon: "groups",
            //   text: "Cat. Rubriques",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   icon: "groups",
            //   text: "Rubriques Depenses",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   icon: "groups",
            //   text: "Blocs",
            //   href: "/admin/Blocs",
            // }

          ],
          links_vente: [
            // {
            //   icon: "groups",
            //   text: "CatégorieProduit",
            //   href: "/admin/CategorieProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Emplacements",
            //   href: "/admin/Emplacements",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Logistique",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Salon",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "CatégorieClient",
            //   href: "/admin/CategorieClient",
            // }
          ],
          links_tresorerie: [
            // {
            //   text: "Rubriques Depenses",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Cat.Rubriques EB",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   text: "Rubriques EB",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   text: "Blocs(Finances)",
            //   href: "/admin/Blocs",
            // },
            // {
            //   text: "Les Services(Finances)",
            //   href: "/admin/Provenance",
            // }
          ],
          links_hotel: [
            // {
            //   text: "ClasseChambre",
            //   href: "/admin/ClasseChambre",
            // },
            // {
            //   text: "Chambres",
            //   href: "/admin/Chambre",
            // },
            // { //SalonProduit
            //   text: "Salles",
            //   href: "/admin/Salle",
            // },
            // { //SalonProduit
            //   text: "Services Salon",
            //   href: "/admin/SalonProduit",
            // }
          ],
          links_personne: [
                // {
                //   text: "Type Agent",
                //   href: "/admin/TypeAgent",
                // },
                // {
                //   text: "Fonctions",
                //   href: "/admin/FonctionAgent",
                // },
                // {
                //   text: "Catégorie Agent",
                //   href: "/admin/CategorieAgent",
                // },
                // {
                //   text: "Type RubriquesPaies",
                //   href: "/admin/CategorieRubriquePers",
                // },
                // {//CategorieCirconstance
                //   text: "Type Contrat",
                //   href: "/admin/TypeContrat",
                // },
                // {//TypeStage
                //   text: "Type Stage",
                //   href: "/admin/TypeStage",
                // },
                // {//CategorieCirconstance
                //   text: "Categorie Circontance",
                //   href: "/admin/CategorieCirconstance",
                // },
                // {
                //   text: "Type Circonstance",
                //   href: "/admin/TypeCirconstance",
                // },
                // {
                //   text: "Les Postes",
                //   href: "/admin/Postes",
                // },
                // {
                //   text: "Les Mutuelles",
                //   href: "/admin/Mutuelle",
                // },
                // {
                //   text: "Lieu Affectation",
                //   href: "/admin/LieuAffectation",
                // },
                // {
                //   text: "RubriquesPaies",
                //   href: "/admin/RubriquePaie",
                // },
                // {
                //   text: "Param. RubriquesPaies",
                //   href: "/admin/ParametreRubrique",
                // },
                // {
                //   text: "Catégorie Service",
                //   href: "/admin/CategorieServicePers",
                // },
                // {
                //   text: "Service Pers.",
                //   href: "/admin/ServicePersonnel",
                // },
                // {
                //   text: "Année Civile",
                //   href: "/admin/Annee",
                // },
                // {
                //   text: "Mois",
                //   href: "/admin/Mois",
                // },
                // {
                //   text: "PromotionAcadémique",
                //   href: "/admin/Promotion",
                // },
                // {
                //   text: "DomaineAcadémique",
                //   href: "/admin/DomaineStage",
                // },
                // {
                //   text: "OptionAcadémique",
                //   href: "/admin/OptionStage",
                // },
                // {
                //   text: "AnnéeAcadémique",
                //   href: "/admin/AnneeStage",
                // },
                // {
                //   text: "InstitutionsAC",
                //   href: "/admin/Institution",
                // },
                // {
                //   text: "Raison Familliale",
                //   href: "/admin/RaisonFamilliale",
                // }
          ],
          links_operation: [
            // {
            //   icon: "store",
            //   text: "Pays",
            //   href: "/admin/pays",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Provinces",
            //   href: "/admin/provinces",
            // },

            // {
            //   icon: "store",
            //   text: "Chef lieu",
            //   href: "/admin/ville",
            // },
            // {
            //   icon: "store",
            //   text: "Commune",
            //   href: "/admin/commune",
            // },

            // {
            //   icon: "store",
            //   text: "Quartier",
            //   href: "/admin/quartier",
            // },

            // {
            //   icon: "store",
            //   text: "Avenue",
            //   href: "/admin/avenue",
            // },

            // {
            //   icon: "store",
            //   text: "Forme juridique",
            //   href: "/admin/forme_juridique",
            // },
            // {
            //   text: "Statistique sur les blogs",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "store",
            //   text: "Territoire",
            //   href: "/admin/territoire",
            // },

            // {
            //   icon: "store",
            //   text: "Envoie SMS",
            //   href: "/admin/texto",
            // },

            // {
            //   icon: "store",
            //   text: "Statistique sur Les utilisateur",
            //   href: "/admin/statistique_user",
            // },


            // {
            //   icon: "api",
            //   text: "Témoignage",
            //   href: "/admin/temoignages",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Valeurs",
            //   href: "/admin/valeur",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Rôles",
            //   href: "/admin/role_service",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Choix",
            //   href: "/admin/choix",
            // },


            // {
            //   icon: "credit_card",
            //   text: "Services",
            //   href: "/admin/service",
            // },


            // {
            //   icon: "api",
            //   text: "Decisions",
            //   href: "/admin/decision",
            // },

            // {
            //   icon: "api",
            //   text: "Avantage",
            //   href: "/admin/avantage",
            // },
            // {
            //   icon: "api",
            //   text: "Sous services",
            //   href: "/admin/sous_service",
            // },
            
          ],
          links_systems: [
            // {
            //   icon: "people",
            //   text: "Utilisateurs",
            //   href: "/admin/Users",
            // },
            // {
            //   icon: "api",
            //   text: "Entreprise",
            //   href: "/admin/liste_entreprise",
            // },
            // {
            //   icon: "api",
            //   text: "Privilège",
            //   href: "/admin/role",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration Menu",
            //   href: "/admin/ListeMenu",
            // },
            // {
            //   icon: "api",
            //   text: "Historiques Infos.",
            //   href: "/admin/HistoriqueData",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Contact pour info",
            //   href: "/admin/contact_info",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration basique",
            //   href: "/admin/configure_basic",
            // },

            // {
            //   icon: "api",
            //   text: "Configuration du site",
            //   href: "/admin/configure_site",
            // },

          ],
          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],
          listPersonnel: [
          {
              text: "RH",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Personnels",
                //   href: "/admin/Agent",
                // },
                // {
                //   text: "Tous les Contrats",
                //   href: "/admin/AllContrat",
                // },
                // {
                //   text: "Contrats Encours",
                //   href: "/admin/ContratActif",
                // },
                // {
                //   text: "En Congé",
                //   href: "/admin/ContratEnconge",
                // },
                // {
                //   text: "Contrats Finis",
                //   href: "/admin/ContratFini",
                // },
                // {
                //   text: "Stages Encours",
                //   href: "/admin/StageEncours",
                // },
                // { //AllPresenceAgent
                //   text: "Tous les Stages",
                //   href: "/admin/AllStages",
                // },
                // { //AllPresenceAgent
                //   text: "Toutes les Présences",
                //   href: "/admin/AllPresenceAgent",
                // },
                // {
                //   text: "Paiement Global",
                //   href: "/admin/FichePaieGlobale",
                // },
                // {
                //   text: "Paiement/Agent",
                //   href: "/admin/FichePaie",
                // },
                // {
                //   text: "Rapports Contrat",
                //   href: "/admin/RapportContrat",
                // },
                // {
                //   text: "Rapports Remuneration Agent",
                //   href: "/admin/RapportsJour_Personnel",
                // },
                // {
                //   text: "Param.SalaireBase",
                //   href: "/admin/ParametreSalairebBase",
                // },
                //ParametreSalairebBase
              ],
            },
          ],
          listPresence: [
            {
              text: "Présences",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Aujourd'hui",
                //   href: "/admin/JourPresences",
                // },
                // {
                //   text: "Toutes les Présences",
                //   href: "/admin/AllPresenceAgent",
                // }
              ],
            },
          ],
          listCorresp: [
            {
              text: "Correspondances",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Aujourd'hui",
                //   href: "/admin/JourCorrespondance",
                // },
                // {
                //   text: "Toutes les Corresp.",
                //   href: "/admin/AllCorrespondance",
                // },
                {
                  text: "Mes Correspondances",
                  href: "/admin/UserCorrespondance",
                }
              ],
            },
          ],
          listTimeSheet: [
            {
              text: "Time Sheets",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Aujourd'hui",
                //   href: "/admin/JourTimeSheet",
                // },
                // {
                //   text: "Tous les TimeSheets.",
                //   href: "/admin/AllTimeSheet",
                // },
                {
                  text: "Mes TimeSheets",
                  href: "/admin/UserTimeSheet",
                }
              ],
            },
          ],
          // listGroup: [
          //   {
          //     text: "Article",
          //     icon: "local_mall",
          //     items: [
          //       {
          //         text: "Catégorie d'article",
          //         href: "/admin/operation_catArticle",
          //       },
          //       {
          //         text: "Blog",
          //         href: "/admin/operation_blog",
          //       },

          //       {
          //         icon: "store",
          //         text: "Mot de la semaine",
          //         href: "/admin/week",
          //       },

          //     ],
          //   },
          // ],
          // listVentes: [
          //   {
          //     text: "Ventes & Stock",
          //     icon: "mdi-cart",
          //     items: [
          //       {
          //         text: "Ventes",
          //         href: "/admin/VenteEnteteVente",
          //       },
          //       {
          //         text: "Clients",
          //         href: "/admin/ClientVente",
          //       },
          //       {
          //         text: "Approvisionnements",
          //         href: "/admin/VenteEnteteEntree",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/VenteEnteteCommande",
          //       },
          //       {
          //         text: "Produits",
          //         href: "/admin/Produits",
          //       },
          //       {
          //         icon: "store",
          //         text: "Fournisseurs",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         icon: "store",
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vente",
          //       },
          //     ],
          //   },
          // ],
          listProjets: [
            {
              text: "Projets",
              icon: "mdi-projector-screen",
              items: [
                {
                  text: "Partenaires",
                  href: "/admin/PartenaireProjet",
                },
                {
                  text: "Projets",
                  href: "/admin/Projets",
                },
                // {
                //   icon: "store",
                //   text: "Rapports",
                //   href: "/admin/RapportsJour_Vente",
                // },
              ],
            },
          ],
          listArchivages: [
          {
              text: "Archivages",
              icon: "mdi-email-open",
              items: [              
                {
                  text: "Archivages",
                  href: "/admin/Archivages", 
                },
                // {
                //   text: "Division",
                //   href: "/admin/DivisionArchive",
                // },
                // {
                //   text: "CategorieArch.",
                //   href: "/admin/CategorieArchivage",
                // },
                // {
                //   text: "Services",
                //   href: "/admin/ServiceArchivage",
                // }
              ],
            },
          ],
          // listReservations: [
          //   {
          //     text: "Resérvations",
          //     icon: "mdi-home",
          //     items: [

          //       {
          //         text: "Chambres",
          //         href: "/admin/ClientHotel",
          //       },
          //       { 
          //         text: "Salles",
          //         href: "/admin/ClientVente",
          //       },
          //       { 
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Reservation",
          //       }

          //     ],
          //   },
          // ],
          // listBillards: [
          //   {
          //     text: "Billards",
          //     icon: "mdi-gamepad",
          //     items: [                
          //       {
          //         text: "Billards",
          //         href: "/admin/ClientVente",
          //       }
          //     ],
          //   },
          // ],
          // listFinances: [
          //   {
          //     text: "Finances",
          //     icon: "mdi-cards",
          //     items: [                
          //       {
          //         text: "Recettes",
          //         href: "/admin/recette",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/EnteteEtatBesoin",
          //       },
          //       {
          //         text: "Bon d'Engagement",
          //         href: "/admin/EnteteBonEngagement",
          //       },
          //       {
          //         text: "Cloture de la Caisse",
          //         href: "/admin/Cloture_Caisse",
          //       },
          //       // {
          //       //   text: "Cloture de la Caisse Hotel",
          //       //   href: "/admin/Cloture_Caisse_Chambre",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Salle",
          //       //   href: "/admin/Cloture_Caisse_Salle",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Billards",
          //       //   href: "/admin/Cloture_Caisse_Billard",
          //       // },
          //       { 
          //         text: "Comptabilité(Opé.)",
          //         href: "/admin/EnteteOperationComptable",
          //       },
          //       { 
          //         text: "Cloture de la Comptabilité",
          //         href: "/admin/ClotureComptabilite",
          //       },
          //       {
          //         text: "Rapport Comptabilité",
          //         href: "/admin/RapportsComptabilite"
          //         //Services
          //       },
          //       {
          //         text: "Rapport Recettes/Depenses",
          //         href: "/admin/RapportsJour_Caisse"
          //       },
          //       { //RapportContrat
          //         text: "Rapports Remuneration Agent",
          //         href: "/admin/RapportsJour_Personnel",
          //       },
          //       {
          //         text: "Les Services",
          //         href: "/admin/Services"
          //       }
          //     ],
          //   },
          // ],
          // listLogistique: [
          //   {
          //     text: "Logistique",
          //     icon: "mdi-cart",
          //     items: [                
          //     {
          //         text: "Approvisionements",
          //         href: "/admin/LogEnteteEntree",
          //       },
          //       {
          //         text: "Sortie/Services",
          //         href: "/admin/LogEnteteSortie",
          //       },
          //       {
          //         text: "Requisitions",
          //         href: "/admin/LogEnteteRequisition",
          //       },
          //       {
          //         text: "Articles",
          //         href: "/admin/ProduitLog",
          //       },
          //       {
          //         text: "Fournisseur",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         text: "Categorie Art.",
          //         href: "/admin/categorieproduit",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Logistique",
          //       }

          //     ],
          //   },
          // ],

          // listVehicules: [
          //   { 
          //     text: "Véhicules",
          //     icon: "mdi-car",
          //     items: [                
          //       {
          //         text: "Mouvements des Véhicules",
          //         href: "/admin/CarEnteteMouvement",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vehicule",
          //       },
          //       {
          //         text: "Nos Véhicules",
          //         href: "/admin/CarVehicule",
          //       },
          //       {
          //         text: "Les Gammes",
          //         href: "/admin/CarProduit",
          //       },
          //       {
          //         text: "Les Fournisseurs",
          //         href: "/admin/CarProducteur",
          //       }
          //     ],
          //   },
          // ],
          // listSalon: [
          //   { 
          //     text: "Salon de Beauté",
          //     icon: "mdi-car",
          //     items: [              
          //        { 
          //          text: "Salon de Beauté",
          //          href: "/admin/SalonEnteteVente",
          //        },
          //        { 
          //          text: "Rapports(Salon)",
          //          href: "/admin/RapportsJour_VenteSalon",
          //        }
          //     ],
          //   },
          // ],
          links_systems_mouvement: [
          ],
          links_systems_mouvement_2: [
            // ProfilPatient
          ],
          links_systems_mouvement_3: [
          ],

          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };
      }
      else if (this.userData.id_role == 5) {
        this.linkAdmin = {
          links: [
            // {
            //   icon: "mdi-microsoft-windows",
            //   text: "Tableau de bord",
            //   href: "/admin/dashboard",
            // },
            // {
            //   icon: "mdi-chart-pie",
            //   text: "Tableau de bord(Ese)",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "chat",
            //   text: "Chat",
            //   href: "/admin/chat",
            // },
          ],
          links_operation_2: [
            // {
            //   icon: "credit_card",
            //   text: "Carousel",
            //   href: "/admin/carousel",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Service",
            //   href: "/admin/operation_service",
            // },
            // {
            //   icon: "store",
            //   text: "Galérie",
            //   href: "/admin/operation_galery",
            // },
            // {
            //   icon: "store",
            //   text: "Vidéo",
            //   href: "/admin/operation_video",
            // },
            // {
            //   icon: "store",
            //   text: "Partenaire",
            //   href: "/admin/operation_partenaire",
            // },

            // {
            //   icon: "store",
            //   text: "Notre famille",
            //   href: "/admin/operation_team",
            // },

          ],
          links_finance: [
            // {
            //   icon: "groups",
            //   text: "Classes",
            //   href: "/admin/ClassesFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Comptes",
            //   href: "/admin/CompteFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Sous Comptes",
            //   href: "/admin/SousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "SSous Comptes",
            //   href: "/admin/SSousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Compte",
            //   href: "/admin/TypeCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Config. Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Position",
            //   href: "/admin/TypePosition",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Opération",
            //   href: "/admin/TypeOperation",
            // },
            // {
            //   text: "Rubriques",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Caisse&Banque",
            //   href: "/admin/Banque",
            // },
            // {
            //   text: "ModePaie",
            //   href: "/admin/modepaie",
            // },
            // {
            //   icon: "groups",
            //   text: "Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Services Treseorerie",
            //   href: "/admin/Provenance",
            // },
            // {
            //   icon: "groups",
            //   text: "Cat. Rubriques",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   icon: "groups",
            //   text: "Rubriques Depenses",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   icon: "groups",
            //   text: "Blocs",
            //   href: "/admin/Blocs",
            // }

          ],
          links_vente: [
            // {
            //   icon: "groups",
            //   text: "CatégorieProduit",
            //   href: "/admin/CategorieProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Emplacements",
            //   href: "/admin/Emplacements",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Logistique",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Salon",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "CatégorieClient",
            //   href: "/admin/CategorieClient",
            // }
          ],
          links_tresorerie: [
            // {
            //   text: "Rubriques Depenses",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Cat.Rubriques EB",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   text: "Rubriques EB",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   text: "Blocs(Finances)",
            //   href: "/admin/Blocs",
            // },
            // {
            //   text: "Les Services(Finances)",
            //   href: "/admin/Provenance",
            // }
          ],
          links_hotel: [
            // {
            //   text: "ClasseChambre",
            //   href: "/admin/ClasseChambre",
            // },
            // {
            //   text: "Chambres",
            //   href: "/admin/Chambre",
            // },
            // { //SalonProduit
            //   text: "Salles",
            //   href: "/admin/Salle",
            // },
            // { //SalonProduit
            //   text: "Services Salon",
            //   href: "/admin/SalonProduit",
            // }
          ],
          links_personne: [
                // {
                //   text: "Type Agent",
                //   href: "/admin/TypeAgent",
                // },
                // {
                //   text: "Fonctions",
                //   href: "/admin/FonctionAgent",
                // },
                // {
                //   text: "Catégorie Agent",
                //   href: "/admin/CategorieAgent",
                // },
                // {
                //   text: "Type RubriquesPaies",
                //   href: "/admin/CategorieRubriquePers",
                // },
                // {//CategorieCirconstance
                //   text: "Type Contrat",
                //   href: "/admin/TypeContrat",
                // },
                // {//TypeStage
                //   text: "Type Stage",
                //   href: "/admin/TypeStage",
                // },
                // {//CategorieCirconstance
                //   text: "Categorie Circontance",
                //   href: "/admin/CategorieCirconstance",
                // },
                // {
                //   text: "Type Circonstance",
                //   href: "/admin/TypeCirconstance",
                // },
                // {
                //   text: "Les Postes",
                //   href: "/admin/Postes",
                // },
                // {
                //   text: "Les Mutuelles",
                //   href: "/admin/Mutuelle",
                // },
                // {
                //   text: "Lieu Affectation",
                //   href: "/admin/LieuAffectation",
                // },
                // {
                //   text: "RubriquesPaies",
                //   href: "/admin/RubriquePaie",
                // },
                // {
                //   text: "Param. RubriquesPaies",
                //   href: "/admin/ParametreRubrique",
                // },
                // {
                //   text: "Catégorie Service",
                //   href: "/admin/CategorieServicePers",
                // },
                // {
                //   text: "Service Pers.",
                //   href: "/admin/ServicePersonnel",
                // },
                // {
                //   text: "Année Civile",
                //   href: "/admin/Annee",
                // },
                // {
                //   text: "Mois",
                //   href: "/admin/Mois",
                // },
                // {
                //   text: "PromotionAcadémique",
                //   href: "/admin/Promotion",
                // },
                // {
                //   text: "DomaineAcadémique",
                //   href: "/admin/DomaineStage",
                // },
                // {
                //   text: "OptionAcadémique",
                //   href: "/admin/OptionStage",
                // },
                // {
                //   text: "AnnéeAcadémique",
                //   href: "/admin/AnneeStage",
                // },
                // {
                //   text: "InstitutionsAC",
                //   href: "/admin/Institution",
                // },
                // {
                //   text: "Raison Familliale",
                //   href: "/admin/RaisonFamilliale",
                // }
          ],
          links_operation: [
            // {
            //   icon: "store",
            //   text: "Pays",
            //   href: "/admin/pays",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Provinces",
            //   href: "/admin/provinces",
            // },

            // {
            //   icon: "store",
            //   text: "Chef lieu",
            //   href: "/admin/ville",
            // },
            // {
            //   icon: "store",
            //   text: "Commune",
            //   href: "/admin/commune",
            // },

            // {
            //   icon: "store",
            //   text: "Quartier",
            //   href: "/admin/quartier",
            // },

            // {
            //   icon: "store",
            //   text: "Avenue",
            //   href: "/admin/avenue",
            // },

            // {
            //   icon: "store",
            //   text: "Forme juridique",
            //   href: "/admin/forme_juridique",
            // },
            // {
            //   text: "Statistique sur les blogs",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "store",
            //   text: "Territoire",
            //   href: "/admin/territoire",
            // },

            // {
            //   icon: "store",
            //   text: "Envoie SMS",
            //   href: "/admin/texto",
            // },

            // {
            //   icon: "store",
            //   text: "Statistique sur Les utilisateur",
            //   href: "/admin/statistique_user",
            // },


            // {
            //   icon: "api",
            //   text: "Témoignage",
            //   href: "/admin/temoignages",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Valeurs",
            //   href: "/admin/valeur",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Rôles",
            //   href: "/admin/role_service",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Choix",
            //   href: "/admin/choix",
            // },


            // {
            //   icon: "credit_card",
            //   text: "Services",
            //   href: "/admin/service",
            // },


            // {
            //   icon: "api",
            //   text: "Decisions",
            //   href: "/admin/decision",
            // },

            // {
            //   icon: "api",
            //   text: "Avantage",
            //   href: "/admin/avantage",
            // },
            // {
            //   icon: "api",
            //   text: "Sous services",
            //   href: "/admin/sous_service",
            // },






          ],
          links_systems: [
            // {
            //   icon: "people",
            //   text: "Utilisateurs",
            //   href: "/admin/Users",
            // },
            // {
            //   icon: "api",
            //   text: "Entreprise",
            //   href: "/admin/liste_entreprise",
            // },
            // {
            //   icon: "api",
            //   text: "Privilège",
            //   href: "/admin/role",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration Menu",
            //   href: "/admin/ListeMenu",
            // },
            // {
            //   icon: "api",
            //   text: "Historiques Infos.",
            //   href: "/admin/HistoriqueData",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Contact pour info",
            //   href: "/admin/contact_info",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration basique",
            //   href: "/admin/configure_basic",
            // },

            // {
            //   icon: "api",
            //   text: "Configuration du site",
            //   href: "/admin/configure_site",
            // },

          ],
          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],
          listPersonnel: [
          // {
          //     text: "RH",
          //     icon: "mdi-account-settings",
          //     items: [                
          //       {
          //         text: "Personnels",
          //         href: "/admin/Agent",
          //       },
          //       {
          //         text: "Tous les Contrats",
          //         href: "/admin/AllContrat",
          //       },
          //       {
          //         text: "Contrats Encours",
          //         href: "/admin/ContratActif",
          //       },
          //       {
          //         text: "En Congé",
          //         href: "/admin/ContratEnconge",
          //       },
          //       {
          //         text: "Contrats Finis",
          //         href: "/admin/ContratFini",
          //       },
          //       {
          //         text: "Stages Encours",
          //         href: "/admin/StageEncours",
          //       },
          //       { //AllPresenceAgent
          //         text: "Tous les Stages",
          //         href: "/admin/AllStages",
          //       },
          //       { //AllPresenceAgent
          //         text: "Toutes les Présences",
          //         href: "/admin/AllPresenceAgent",
          //       },
          //       {
          //         text: "Paiement Global",
          //         href: "/admin/FichePaieGlobale",
          //       },
          //       {
          //         text: "Paiement/Agent",
          //         href: "/admin/FichePaie",
          //       },
          //       {
          //         text: "Rapports Contrat",
          //         href: "/admin/RapportContrat",
          //       },
          //       {
          //         text: "Rapports Remuneration Agent",
          //         href: "/admin/RapportsJour_Personnel",
          //       },
          //       {
          //         text: "Param.SalaireBase",
          //         href: "/admin/ParametreSalairebBase",
          //       },
          //       //ParametreSalairebBase
          //     ],
          //   },
          ],
          listPresence: [
            // {
            //   text: "Présences",
            //   icon: "mdi-account-settings",
            //   items: [                
            //     {
            //       text: "Aujourd'hui",
            //       href: "/admin/JourPresences",
            //     },
            //     {
            //       text: "Toutes les Présences",
            //       href: "/admin/AllPresenceAgent",
            //     }
            //   ],
            // },
          ],
          listCorresp: [
            {
              text: "Correspondances",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Aujourd'hui",
                //   href: "/admin/JourCorrespondance",
                // },
                // {
                //   text: "Toutes les Corresp.",
                //   href: "/admin/AllCorrespondance",
                // },
                {
                  text: "Mes Correspondances",
                  href: "/admin/UserCorrespondance",
                }
              ],
            },
          ],
          listTimeSheet: [
            {
              text: "Time Sheets",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Aujourd'hui",
                //   href: "/admin/JourTimeSheet",
                // },
                // {
                //   text: "Tous les TimeSheets.",
                //   href: "/admin/AllTimeSheet",
                // },
                {
                  text: "Mes TimeSheets",
                  href: "/admin/UserTimeSheet",
                }
              ],
            },
          ],
          // listGroup: [
          //   {
          //     text: "Article",
          //     icon: "local_mall",
          //     items: [

          //       {

          //         text: "Catégorie d'article",
          //         href: "/admin/operation_catArticle",
          //       },
          //       {
          //         text: "Blog",
          //         href: "/admin/operation_blog",
          //       },

          //       {
          //         icon: "store",
          //         text: "Mot de la semaine",
          //         href: "/admin/week",
          //       },

          //     ],
          //   },
          // ],
          // listVentes: [
          //   {
          //     text: "Ventes & Stock",
          //     icon: "mdi-cart",
          //     items: [
          //       {
          //         text: "Ventes",
          //         href: "/admin/VenteEnteteVente",
          //       },
          //       {
          //         text: "Clients",
          //         href: "/admin/ClientVente",
          //       },
          //       {
          //         text: "Approvisionnements",
          //         href: "/admin/VenteEnteteEntree",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/VenteEnteteCommande",
          //       },
          //       {
          //         text: "Produits",
          //         href: "/admin/Produits",
          //       },
          //       {
          //         icon: "store",
          //         text: "Fournisseurs",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         icon: "store",
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vente",
          //       },
          //     ],
          //   },
          // ],
          listProjets: [
            // {
            //   text: "Projets",
            //   icon: "mdi-projector-screen",
            //   items: [
            //     {
            //       text: "Partenaires",
            //       href: "/admin/PartenaireProjet",
            //     },
            //     {
            //       text: "Projets",
            //       href: "/admin/Projets",
            //     },
            //     {
            //       icon: "store",
            //       text: "Rapports",
            //       href: "/admin/RapportsJour_Vente",
            //     },
            //   ],
            // },
          ],
          listArchivages: [
          // {
          //     text: "Archivages",
          //     icon: "mdi-email-open",
          //     items: [              
          //       {
          //         text: "Archivages",
          //         href: "/admin/Archivages", 
          //       },
          //       {
          //         text: "Division",
          //         href: "/admin/DivisionArchive",
          //       },
          //       {
          //         text: "CategorieArch.",
          //         href: "/admin/CategorieArchivage",
          //       },
          //       {
          //         text: "Services",
          //         href: "/admin/ServiceArchivage",
          //       }
          //     ],
          //   },
          ],
          // listReservations: [
          //   {
          //     text: "Resérvations",
          //     icon: "mdi-home",
          //     items: [

          //       {
          //         text: "Chambres",
          //         href: "/admin/ClientHotel",
          //       },
          //       { 
          //         text: "Salles",
          //         href: "/admin/ClientVente",
          //       },
          //       { 
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Reservation",
          //       }

          //     ],
          //   },
          // ],
          // listBillards: [
          //   {
          //     text: "Billards",
          //     icon: "mdi-gamepad",
          //     items: [                
          //       {
          //         text: "Billards",
          //         href: "/admin/ClientVente",
          //       }
          //     ],
          //   },
          // ],
          // listFinances: [
          //   {
          //     text: "Finances",
          //     icon: "mdi-cards",
          //     items: [                
          //       {
          //         text: "Recettes",
          //         href: "/admin/recette",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/EnteteEtatBesoin",
          //       },
          //       {
          //         text: "Bon d'Engagement",
          //         href: "/admin/EnteteBonEngagement",
          //       },
          //       {
          //         text: "Cloture de la Caisse",
          //         href: "/admin/Cloture_Caisse",
          //       },
          //       // {
          //       //   text: "Cloture de la Caisse Hotel",
          //       //   href: "/admin/Cloture_Caisse_Chambre",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Salle",
          //       //   href: "/admin/Cloture_Caisse_Salle",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Billards",
          //       //   href: "/admin/Cloture_Caisse_Billard",
          //       // },
          //       { 
          //         text: "Comptabilité(Opé.)",
          //         href: "/admin/EnteteOperationComptable",
          //       },
          //       { 
          //         text: "Cloture de la Comptabilité",
          //         href: "/admin/ClotureComptabilite",
          //       },
          //       {
          //         text: "Rapport Comptabilité",
          //         href: "/admin/RapportsComptabilite"
          //         //Services
          //       },
          //       {
          //         text: "Rapport Recettes/Depenses",
          //         href: "/admin/RapportsJour_Caisse"
          //       },
          //       { //RapportContrat
          //         text: "Rapports Remuneration Agent",
          //         href: "/admin/RapportsJour_Personnel",
          //       },
          //       {
          //         text: "Les Services",
          //         href: "/admin/Services"
          //       }
          //     ],
          //   },
          // ],
          // listLogistique: [
          //   {
          //     text: "Logistique",
          //     icon: "mdi-cart",
          //     items: [                
          //     {
          //         text: "Approvisionements",
          //         href: "/admin/LogEnteteEntree",
          //       },
          //       {
          //         text: "Sortie/Services",
          //         href: "/admin/LogEnteteSortie",
          //       },
          //       {
          //         text: "Requisitions",
          //         href: "/admin/LogEnteteRequisition",
          //       },
          //       {
          //         text: "Articles",
          //         href: "/admin/ProduitLog",
          //       },
          //       {
          //         text: "Fournisseur",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         text: "Categorie Art.",
          //         href: "/admin/categorieproduit",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Logistique",
          //       }

          //     ],
          //   },
          // ],

          // listVehicules: [
          //   { 
          //     text: "Véhicules",
          //     icon: "mdi-car",
          //     items: [                
          //       {
          //         text: "Mouvements des Véhicules",
          //         href: "/admin/CarEnteteMouvement",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vehicule",
          //       },
          //       {
          //         text: "Nos Véhicules",
          //         href: "/admin/CarVehicule",
          //       },
          //       {
          //         text: "Les Gammes",
          //         href: "/admin/CarProduit",
          //       },
          //       {
          //         text: "Les Fournisseurs",
          //         href: "/admin/CarProducteur",
          //       }
          //     ],
          //   },
          // ],
          // listSalon: [
          //   { 
          //     text: "Salon de Beauté",
          //     icon: "mdi-car",
          //     items: [              
          //        { 
          //          text: "Salon de Beauté",
          //          href: "/admin/SalonEnteteVente",
          //        },
          //        { 
          //          text: "Rapports(Salon)",
          //          href: "/admin/RapportsJour_VenteSalon",
          //        }
          //     ],
          //   },
          // ],
          links_systems_mouvement: [
          ],
          links_systems_mouvement_2: [
            // ProfilPatient
          ],
          links_systems_mouvement_3: [
          ],

          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };
      }
      else if (this.userData.id_role == 6) {
        this.linkAdmin = {
          links: [
            // {
            //   icon: "mdi-microsoft-windows",
            //   text: "Tableau de bord",
            //   href: "/admin/dashboard",
            // },
            // {
            //   icon: "mdi-chart-pie",
            //   text: "Tableau de bord(Ese)",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "chat",
            //   text: "Chat",
            //   href: "/admin/chat",
            // },
          ],
          links_operation_2: [
            // {
            //   icon: "credit_card",
            //   text: "Carousel",
            //   href: "/admin/carousel",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Service",
            //   href: "/admin/operation_service",
            // },
            // {
            //   icon: "store",
            //   text: "Galérie",
            //   href: "/admin/operation_galery",
            // },
            // {
            //   icon: "store",
            //   text: "Vidéo",
            //   href: "/admin/operation_video",
            // },
            // {
            //   icon: "store",
            //   text: "Partenaire",
            //   href: "/admin/operation_partenaire",
            // },

            // {
            //   icon: "store",
            //   text: "Notre famille",
            //   href: "/admin/operation_team",
            // },

          ],
          links_finance: [
            // {
            //   icon: "groups",
            //   text: "Classes",
            //   href: "/admin/ClassesFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Comptes",
            //   href: "/admin/CompteFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Sous Comptes",
            //   href: "/admin/SousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "SSous Comptes",
            //   href: "/admin/SSousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Compte",
            //   href: "/admin/TypeCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Config. Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Position",
            //   href: "/admin/TypePosition",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Opération",
            //   href: "/admin/TypeOperation",
            // },
            // {
            //   text: "Rubriques",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Caisse&Banque",
            //   href: "/admin/Banque",
            // },
            // {
            //   text: "ModePaie",
            //   href: "/admin/modepaie",
            // },
            // {
            //   icon: "groups",
            //   text: "Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Services Treseorerie",
            //   href: "/admin/Provenance",
            // },
            // {
            //   icon: "groups",
            //   text: "Cat. Rubriques",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   icon: "groups",
            //   text: "Rubriques Depenses",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   icon: "groups",
            //   text: "Blocs",
            //   href: "/admin/Blocs",
            // }

          ],
          links_vente: [
            // {
            //   icon: "groups",
            //   text: "CatégorieProduit",
            //   href: "/admin/CategorieProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Emplacements",
            //   href: "/admin/Emplacements",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Logistique",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Service Salon",
            //   href: "/admin/SalonProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "CatégorieClient",
            //   href: "/admin/CategorieClient",
            // }
          ],
          links_tresorerie: [
            // {
            //   text: "Rubriques Depenses",
            //   href: "/admin/Comptes",
            // },
            // {
            //   text: "Cat.Rubriques EB",
            //   href: "/admin/CategorieRubrique",
            // },
            // {
            //   text: "Rubriques EB",
            //   href: "/admin/Rubriques",
            // },
            // {
            //   text: "Blocs(Finances)",
            //   href: "/admin/Blocs",
            // },
            // {
            //   text: "Les Services(Finances)",
            //   href: "/admin/Provenance",
            // }
          ],
          links_hotel: [
            // {
            //   text: "ClasseChambre",
            //   href: "/admin/ClasseChambre",
            // },
            // {
            //   text: "Chambres",
            //   href: "/admin/Chambre",
            // },
            // { //SalonProduit
            //   text: "Salles",
            //   href: "/admin/Salle",
            // },
            // { //SalonProduit
            //   text: "Services Salon",
            //   href: "/admin/SalonProduit",
            // }
          ],
          links_personne: [
                // {
                //   text: "Type Agent",
                //   href: "/admin/TypeAgent",
                // },
                // {
                //   text: "Fonctions",
                //   href: "/admin/FonctionAgent",
                // },
                // {
                //   text: "Catégorie Agent",
                //   href: "/admin/CategorieAgent",
                // },
                // {
                //   text: "Type RubriquesPaies",
                //   href: "/admin/CategorieRubriquePers",
                // },
                // {//CategorieCirconstance
                //   text: "Type Contrat",
                //   href: "/admin/TypeContrat",
                // },
                // {//TypeStage
                //   text: "Type Stage",
                //   href: "/admin/TypeStage",
                // },
                // {//CategorieCirconstance
                //   text: "Categorie Circontance",
                //   href: "/admin/CategorieCirconstance",
                // },
                // {
                //   text: "Type Circonstance",
                //   href: "/admin/TypeCirconstance",
                // },
                // {
                //   text: "Les Postes",
                //   href: "/admin/Postes",
                // },
                // {
                //   text: "Les Mutuelles",
                //   href: "/admin/Mutuelle",
                // },
                // {
                //   text: "Lieu Affectation",
                //   href: "/admin/LieuAffectation",
                // },
                // {
                //   text: "RubriquesPaies",
                //   href: "/admin/RubriquePaie",
                // },
                // {
                //   text: "Param. RubriquesPaies",
                //   href: "/admin/ParametreRubrique",
                // },
                // {
                //   text: "Catégorie Service",
                //   href: "/admin/CategorieServicePers",
                // },
                // {
                //   text: "Service Pers.",
                //   href: "/admin/ServicePersonnel",
                // },
                // {
                //   text: "Année Civile",
                //   href: "/admin/Annee",
                // },
                // {
                //   text: "Mois",
                //   href: "/admin/Mois",
                // },
                // {
                //   text: "PromotionAcadémique",
                //   href: "/admin/Promotion",
                // },
                // {
                //   text: "DomaineAcadémique",
                //   href: "/admin/DomaineStage",
                // },
                // {
                //   text: "OptionAcadémique",
                //   href: "/admin/OptionStage",
                // },
                // {
                //   text: "AnnéeAcadémique",
                //   href: "/admin/AnneeStage",
                // },
                // {
                //   text: "InstitutionsAC",
                //   href: "/admin/Institution",
                // },
                // {
                //   text: "Raison Familliale",
                //   href: "/admin/RaisonFamilliale",
                // }
          ],
          links_operation: [
            // {
            //   icon: "store",
            //   text: "Pays",
            //   href: "/admin/pays",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Provinces",
            //   href: "/admin/provinces",
            // },

            // {
            //   icon: "store",
            //   text: "Chef lieu",
            //   href: "/admin/ville",
            // },
            // {
            //   icon: "store",
            //   text: "Commune",
            //   href: "/admin/commune",
            // },

            // {
            //   icon: "store",
            //   text: "Quartier",
            //   href: "/admin/quartier",
            // },

            // {
            //   icon: "store",
            //   text: "Avenue",
            //   href: "/admin/avenue",
            // },

            // {
            //   icon: "store",
            //   text: "Forme juridique",
            //   href: "/admin/forme_juridique",
            // },
            // {
            //   text: "Statistique sur les blogs",
            //   href: "/admin/statistique_entreprise",
            // },
            // {
            //   icon: "store",
            //   text: "Territoire",
            //   href: "/admin/territoire",
            // },

            // {
            //   icon: "store",
            //   text: "Envoie SMS",
            //   href: "/admin/texto",
            // },

            // {
            //   icon: "store",
            //   text: "Statistique sur Les utilisateur",
            //   href: "/admin/statistique_user",
            // },


            // {
            //   icon: "api",
            //   text: "Témoignage",
            //   href: "/admin/temoignages",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Valeurs",
            //   href: "/admin/valeur",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Rôles",
            //   href: "/admin/role_service",
            // },

            // {
            //   icon: "api",
            //   text: "Nos Choix",
            //   href: "/admin/choix",
            // },


            // {
            //   icon: "credit_card",
            //   text: "Services",
            //   href: "/admin/service",
            // },


            // {
            //   icon: "api",
            //   text: "Decisions",
            //   href: "/admin/decision",
            // },

            // {
            //   icon: "api",
            //   text: "Avantage",
            //   href: "/admin/avantage",
            // },
            // {
            //   icon: "api",
            //   text: "Sous services",
            //   href: "/admin/sous_service",
            // },

          ],
          links_systems: [
            // {
            //   icon: "people",
            //   text: "Utilisateurs",
            //   href: "/admin/Users",
            // },
            // {
            //   icon: "api",
            //   text: "Entreprise",
            //   href: "/admin/liste_entreprise",
            // },
            // {
            //   icon: "api",
            //   text: "Privilège",
            //   href: "/admin/role",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration Menu",
            //   href: "/admin/ListeMenu",
            // },
            // {
            //   icon: "api",
            //   text: "Historiques Infos.",
            //   href: "/admin/HistoriqueData",
            // },
            // {
            //   icon: "credit_card",
            //   text: "Contact pour info",
            //   href: "/admin/contact_info",
            // },
            // {
            //   icon: "api",
            //   text: "Configuration basique",
            //   href: "/admin/configure_basic",
            // },

            // {
            //   icon: "api",
            //   text: "Configuration du site",
            //   href: "/admin/configure_site",
            // },

          ],
          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],
          listPersonnel: [
          {
              text: "RH",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Personnels",
                //   href: "/admin/Agent",
                // },
                // {
                //   text: "Tous les Contrats",
                //   href: "/admin/AllContrat",
                // },
                // {
                //   text: "Contrats Encours",
                //   href: "/admin/ContratActif",
                // },
                // {
                //   text: "En Congé",
                //   href: "/admin/ContratEnconge",
                // },
                // {
                //   text: "Contrats Finis",
                //   href: "/admin/ContratFini",
                // },
                // {
                //   text: "Stages Encours",
                //   href: "/admin/StageEncours",
                // },
                // { //AllPresenceAgent
                //   text: "Tous les Stages",
                //   href: "/admin/AllStages",
                // },
                // { //AllPresenceAgent
                //   text: "Toutes les Présences",
                //   href: "/admin/AllPresenceAgent",
                // },
                {
                  text: "Paiement Global",
                  href: "/admin/FichePaieGlobale",
                },
                {
                  text: "Paiement/Agent",
                  href: "/admin/FichePaie",
                },
                // {
                //   text: "Rapports Contrat",
                //   href: "/admin/RapportContrat",
                // },
                {
                  text: "Rapports Remuneration Agent",
                  href: "/admin/RapportsJour_Personnel",
                },
                {
                  text: "Param.SalaireBase",
                  href: "/admin/ParametreSalairebBase",
                },
                //ParametreSalairebBase
              ],
            },
          ],
          listPresence: [
            // {
            //   text: "Présences",
            //   icon: "mdi-account-settings",
            //   items: [                
            //     {
            //       text: "Aujourd'hui",
            //       href: "/admin/JourPresences",
            //     },
            //     {
            //       text: "Toutes les Présences",
            //       href: "/admin/AllPresenceAgent",
            //     }
            //   ],
            // },
          ],
          listCorresp: [
            {
              text: "Correspondances",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Aujourd'hui",
                //   href: "/admin/JourCorrespondance",
                // },
                // {
                //   text: "Toutes les Corresp.",
                //   href: "/admin/AllCorrespondance",
                // },
                {
                  text: "Mes Correspondances",
                  href: "/admin/UserCorrespondance",
                }
              ],
            },
          ],
          listTimeSheet: [
            {
              text: "Time Sheets",
              icon: "mdi-account-settings",
              items: [                
                // {
                //   text: "Aujourd'hui",
                //   href: "/admin/JourTimeSheet",
                // },
                // {
                //   text: "Tous les TimeSheets.",
                //   href: "/admin/AllTimeSheet",
                // },
                {
                  text: "Mes TimeSheets",
                  href: "/admin/UserTimeSheet",
                }
              ],
            },
          ],
          // listGroup: [
          //   {
          //     text: "Article",
          //     icon: "local_mall",
          //     items: [

          //       {

          //         text: "Catégorie d'article",
          //         href: "/admin/operation_catArticle",
          //       },
          //       {
          //         text: "Blog",
          //         href: "/admin/operation_blog",
          //       },

          //       {
          //         icon: "store",
          //         text: "Mot de la semaine",
          //         href: "/admin/week",
          //       },

          //     ],
          //   },
          // ],
          // listVentes: [
          //   {
          //     text: "Ventes & Stock",
          //     icon: "mdi-cart",
          //     items: [
          //       {
          //         text: "Ventes",
          //         href: "/admin/VenteEnteteVente",
          //       },
          //       {
          //         text: "Clients",
          //         href: "/admin/ClientVente",
          //       },
          //       {
          //         text: "Approvisionnements",
          //         href: "/admin/VenteEnteteEntree",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/VenteEnteteCommande",
          //       },
          //       {
          //         text: "Produits",
          //         href: "/admin/Produits",
          //       },
          //       {
          //         icon: "store",
          //         text: "Fournisseurs",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         icon: "store",
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vente",
          //       },
          //     ],
          //   },
          // ],
          listProjets: [
            // {
            //   text: "Projets",
            //   icon: "mdi-projector-screen",
            //   items: [
            //     {
            //       text: "Partenaires",
            //       href: "/admin/PartenaireProjet",
            //     },
            //     {
            //       text: "Projets",
            //       href: "/admin/Projets",
            //     },
            //     {
            //       icon: "store",
            //       text: "Rapports",
            //       href: "/admin/RapportsJour_Vente",
            //     },
            //   ],
            // },
          ],
          listArchivages: [
          {
              text: "Archivages",
              icon: "mdi-email-open",
              items: [              
                {
                  text: "Archivages",
                  href: "/admin/Archivages", 
                },
                // {
                //   text: "Division",
                //   href: "/admin/DivisionArchive",
                // },
                // {
                //   text: "CategorieArch.",
                //   href: "/admin/CategorieArchivage",
                // },
                // {
                //   text: "Services",
                //   href: "/admin/ServiceArchivage",
                // }
              ],
            },
          ],
          // listReservations: [
          //   {
          //     text: "Resérvations",
          //     icon: "mdi-home",
          //     items: [

          //       {
          //         text: "Chambres",
          //         href: "/admin/ClientHotel",
          //       },
          //       { 
          //         text: "Salles",
          //         href: "/admin/ClientVente",
          //       },
          //       { 
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Reservation",
          //       }

          //     ],
          //   },
          // ],
          // listBillards: [
          //   {
          //     text: "Billards",
          //     icon: "mdi-gamepad",
          //     items: [                
          //       {
          //         text: "Billards",
          //         href: "/admin/ClientVente",
          //       }
          //     ],
          //   },
          // ],
          // listFinances: [
          //   {
          //     text: "Finances",
          //     icon: "mdi-cards",
          //     items: [                
          //       {
          //         text: "Recettes",
          //         href: "/admin/recette",
          //       },
          //       {
          //         text: "Etat de Besoin",
          //         href: "/admin/EnteteEtatBesoin",
          //       },
          //       {
          //         text: "Bon d'Engagement",
          //         href: "/admin/EnteteBonEngagement",
          //       },
          //       {
          //         text: "Cloture de la Caisse",
          //         href: "/admin/Cloture_Caisse",
          //       },
          //       // {
          //       //   text: "Cloture de la Caisse Hotel",
          //       //   href: "/admin/Cloture_Caisse_Chambre",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Salle",
          //       //   href: "/admin/Cloture_Caisse_Salle",
          //       // },
          //       // {
          //       //   text: "Cloture de la Caisse Billards",
          //       //   href: "/admin/Cloture_Caisse_Billard",
          //       // },
          //       { 
          //         text: "Comptabilité(Opé.)",
          //         href: "/admin/EnteteOperationComptable",
          //       },
          //       { 
          //         text: "Cloture de la Comptabilité",
          //         href: "/admin/ClotureComptabilite",
          //       },
          //       {
          //         text: "Rapport Comptabilité",
          //         href: "/admin/RapportsComptabilite"
          //         //Services
          //       },
          //       {
          //         text: "Rapport Recettes/Depenses",
          //         href: "/admin/RapportsJour_Caisse"
          //       },
          //       { //RapportContrat
          //         text: "Rapports Remuneration Agent",
          //         href: "/admin/RapportsJour_Personnel",
          //       },
          //       {
          //         text: "Les Services",
          //         href: "/admin/Services"
          //       }
          //     ],
          //   },
          // ],
          // listLogistique: [
          //   {
          //     text: "Logistique",
          //     icon: "mdi-cart",
          //     items: [                
          //     {
          //         text: "Approvisionements",
          //         href: "/admin/LogEnteteEntree",
          //       },
          //       {
          //         text: "Sortie/Services",
          //         href: "/admin/LogEnteteSortie",
          //       },
          //       {
          //         text: "Requisitions",
          //         href: "/admin/LogEnteteRequisition",
          //       },
          //       {
          //         text: "Articles",
          //         href: "/admin/ProduitLog",
          //       },
          //       {
          //         text: "Fournisseur",
          //         href: "/admin/Fournisseur",
          //       },
          //       {
          //         text: "Categorie Art.",
          //         href: "/admin/categorieproduit",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Logistique",
          //       }

          //     ],
          //   },
          // ],

          // listVehicules: [
          //   { 
          //     text: "Véhicules",
          //     icon: "mdi-car",
          //     items: [                
          //       {
          //         text: "Mouvements des Véhicules",
          //         href: "/admin/CarEnteteMouvement",
          //       },
          //       {
          //         text: "Rapports",
          //         href: "/admin/RapportsJour_Vehicule",
          //       },
          //       {
          //         text: "Nos Véhicules",
          //         href: "/admin/CarVehicule",
          //       },
          //       {
          //         text: "Les Gammes",
          //         href: "/admin/CarProduit",
          //       },
          //       {
          //         text: "Les Fournisseurs",
          //         href: "/admin/CarProducteur",
          //       }
          //     ],
          //   },
          // ],
          // listSalon: [
          //   { 
          //     text: "Salon de Beauté",
          //     icon: "mdi-car",
          //     items: [              
          //        { 
          //          text: "Salon de Beauté",
          //          href: "/admin/SalonEnteteVente",
          //        },
          //        { 
          //          text: "Rapports(Salon)",
          //          href: "/admin/RapportsJour_VenteSalon",
          //        }
          //     ],
          //   },
          // ],
          links_systems_mouvement: [
          ],
          links_systems_mouvement_2: [
            // ProfilPatient
          ],
          links_systems_mouvement_3: [
          ],

          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };
      }
      else {
      }
    },
  },
};
</script>


